<?php
require_once 'osnova/inicijalizacija.php';
$korisnik = new Korisnik();


// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 				Naprosto ne vredi, dao sam ovoj skripti 5 sati da napravi samo jednu 60x60 osm ali tako da ona zapravo nema prrazna preostala polja	    //
// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (!$korisnik->je_ulogovan_k()) 
{
	Preusmeri::na('registracija.php');
}
if( (!$korisnik->ima_prava('admin')) ) // ako je korisnik admin, prikazi mu ostale linkove
{	
	Preusmeri::na('index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
	<title>Огромне осмосмерке</title>
	<script src="java_script/java_script_sve.js"> 
	</script>
</head>
<body>

<div id="container" class="container"> 
	
	<?php
	echo napravi_heading($korisnik->podaci_k()->tip_korisnika, $korisnik->podaci_k()->id);
	?>

	<h2> Прављење огромних осмосмерки </h2>
	<!-- <h2> Страница не ради: глов </h2> -->

	<details>
		<summary>Додатне информације</summary>
		<p>Скрипта је намењена за правељење огромних осмосмерки.</p>
		<p>Скрипта ради док год не направи осмосмерку са<strong> 0 </strong>преосталих поња, корисити са опрезом.</p>
		<p>Скрипта <strong>нема временско ограничење</strong> рада. Неће се сама завршити након 2 минута што је подразумевана вредност у php.ini.</p>			
		<p>Направљене осмосмерке се складиште у табелу "ogromne_osmosmerke".</p>
		<p>Након што се направи, на екрану ће бити доступни сви евентови као и за решавање осмосмерки.</p>
	</details>

	<form id="forma_o_i" action="" method="post">
		<div id="paralelno">
			<label for="red_velicina_osmosmerke">Унесите висину (<strong>ред</strong>) осмосмерке</label>
			<input type="text" name="red_velicina_osmosmerke" id="red_velicina_osmosmerke" autofocus="autofocus" autocomplete="off">
			<br>
		</div>
		<div id="paralelno">
			<label for="kolona_velicina_osmosmerke">Унесите ширину (<strong>колону</strong>) осмосмерке</label>
			<input type="text" name="kolona_velicina_osmosmerke" id="kolona_velicina_osmosmerke" autocomplete="off">
			<br>
		</div>
		<br>
<!-- 		<div id="paralelno">
			<label for="reci_od_korisnika">Унесите <strong>речи</strong> које желите да буду у осмосмерци (опционално). Сваку реч одвојите зарезом</label><br>
			<input type="text" name="reci_od_korisnika" id="reci_od_korisnika" autocomplete="off">
			<br>
		</div> -->

		<?php 
		if ($korisnik->ima_prava('admin')) 
		{
		?>

			<br>
			<div id="paralelno">
				<input type="radio" id="prikazi_podatke" name="prikazi_podatke" value="true">
				<label id="prikazi_podatke" for="prikazi_podatke">Прикажи додатне податке</label>
				<br>
			</div>

			<br>
			<div id="paralelno">
				<input type="radio" id="prikazi_puteve" name="prikazi_puteve" value="true">
				<label id="prikazi_puteve" for="prikazi_puteve">Прикажи све путеве који пролазе кроз поље (onmouseover event)</label>
				<br>
			</div>

		<?php 
		} 
		?>

		<input type="submit" name="napravi_osmosmerku" value="Направи осмосмерку">
	</form>

	<?php

	if (Input::vrati('napravi_osmosmerku')) 
	{
		$niz_kriterijum_validacija = array(
			'red_velicina_osmosmerke' => array(
				'obavezno' => TRUE,
				'velicina_osmosmerke' => 3				
			),
			'kolona_velicina_osmosmerke' => array(
				'obavezno' => TRUE,
				'velicina_osmosmerke' => 3				
			),				
		);
		
		/*$reci_od_korisnika = explode(",", Input::vrati('reci_od_korisnika'));*/

		$validacija = new Validacija();
		$rez_validacije = $validacija->provera_unosa($_POST, $niz_kriterijum_validacija);

		ini_set('max_execution_time', '0'); // uklanja vremensko ogranice rada skripte

		if($rez_validacije->validacija_uspela())
		{
			// kastovanje promenljivih na int
			$red = (int)Input::vrati('red_velicina_osmosmerke');
			$kolona = (int)Input::vrati('kolona_velicina_osmosmerke');

			$tip_osmosmerke = "ogromna";
			$reci_od_korisnika = '';
			
			do
			{
				if (isset($osmosmerka)) 
				{
					
					if($osmosmerka->vrati_broj_preostalih_polja() >= 1)
					{
						unset($osmosmerka);
						unset($osmosmerka_niz);
						$GLOBALS['unete_reci'] = array();
						$GLOBALS['unete_reci_sa_putevima'] = array();
					}
				}
				$osmosmerka = new Osmosmerka($red, $kolona, $reci_od_korisnika, $korisnik->podaci_k()->id, $tip_osmosmerke);
				$osmosmerka_niz = $osmosmerka->popunjavanje_sa_korisnickim_recima();
				
			} while($osmosmerka->vrati_broj_preostalih_polja() >= 1);

			if( $korisnik->ima_prava('admin') )
			{
				$prikazi_podatke = Input::vrati('prikazi_podatke');
				if($prikazi_podatke == "true") 
				{
					echo '<div class="dodatni_podaci">';
					echo '<h3> Приказ додатних података </h3>'; 

					$br_puteva_klasa = new Testiranje_formule_broja_puteva_u_osm($red, $kolona);
					$br_puteva_rez = $br_puteva_klasa->izracunaj_broj_puteva();
					echo '<h4>Основни подаци</h4>';
					echo "<h5>Величина осмосмерке је <strong>" . $br_puteva_klasa->vrati_red() . " * " . $br_puteva_klasa->vrati_kolonu() . "</strong></h5>";
					echo "<h5>Укупан број путева добијен класом (математичком формулом) Testiranje_formule_broja_puteva_u_osm је: <strong>" . $br_puteva_rez . "</strong></h5>";
					echo '<h5>Број путева <strong>"count(\$niz_svih_puteva)"</strong> из класе Осмосмерка_templejt je: <strong>' . $osmosmerka->vrati_broj_puteva() . '</strong></h5>';
					if( !empty($osmosmerka->vrati_reci_od_korisnika_string()) ){ //!= ", " ko zna sta je ovo bilo
						echo '<h5>Све речи од корисника <strong>' . $osmosmerka->vrati_reci_od_korisnika_string() . '</strong></h5>';
					} else {
						echo '<h5><strong>Није</strong> унета ниједна реч.</h5>';
					}
					echo '<h4>Статистика унетих речи</h4>';
					echo $osmosmerka->prikazi_dodatne_podatke();
					echo '</div>';
				}

				$prikazi_puteve = Input::vrati('prikazi_puteve');
				if($prikazi_puteve == "true"){
					$prikazi_puteve = TRUE;
				} else {
					$prikazi_puteve = FALSE;
				}
			} 

			// -------------------------------podaci za javascript-------------------------------
			$sve_osm = array(
				"red"       =>$osmosmerka->vrati_velicinu_reda(), 
				"kolona"    =>$osmosmerka->vrati_velicinu_kolone(),
				"osmosmerka"=>$osmosmerka_niz,
				"resenje_osmosmerke" => array( "rec_resenja"  => $osmosmerka->vrati_resenje(),
											   "polja_resenja"=> $osmosmerka->vrati_polja_resenja()
										)
			);

			$unete_reci = $osmosmerka->vrati_sve_unete_reci_sa_putevima();
			// -----------------------------------------------------------------------------------
			echo napravi_spisak_reci_za_pronalazenje_u_osm($unete_reci);
			echo "<br>";
			echo napravi_osmosmerku_v1($osmosmerka_niz, $prikazi_puteve); 
			// forma za resenje
			if($sve_osm["resenje_osmosmerke"]["rec_resenja"] == "/")
			{
				// nema resenje
				// osmosmerka se resava pronalaskom svih reci sa spiska
				echo '<br><p class="horizontalno_centriraj_text">Ова осмосмерка се решава проналаском свих речи са списка!</p><br>';
			} else {
				// echo '<br><p>Након проналаска свих слова са списка формирајте решење и унесите га у форму: </p>';
				echo resenje_osmosmerke();
			}	
			// $korisnik->napravio_osmosmerku();

		} else {
			echo '<div id="greske">';
			foreach($rez_validacije->sve_greske() as $greska)
			{
				echo '<p>' . $greska, ' </p>';
			}
			echo '</div>';
		}
	}

	?>

	<div id="content-wrap">
		<footer id="footer"><small>&copy; Copyright 2021.   Dimitrije Drakulić</small></footer>
	</div>
	
</div>

<script > 
	var osm_r_k    = <?php echo json_encode($sve_osm); ?>;
	var unete_reci = <?php echo json_encode($unete_reci); ?>;
	var osmosmerka_obj = osm_r_k.osmosmerka;
	var red = osm_r_k.red;
	var kolona = osm_r_k.kolona;
	var resenje_osmosmerke = osm_r_k.resenje_osmosmerke.rec_resenja;
	var polja_resenja = osm_r_k.polja_resenja;

	osmosmerka_niz = popuni_osmosmerku(instanciraj_tablicu(red, kolona), osmosmerka_obj, red, kolona);

	let resavanje_osmosmerke_obj = new Resavanje_osmosmerke(null, null, unete_reci);
	let aktivno_polje_obj        = new Aktivno_polje();
	let pronadjene_reci_obj      = new Pronadjene_reci();
	let konacno_resenje_obj      = new Konacno_resenje(resenje_osmosmerke);
	let Highlight_obj            = new Highlight(unete_reci);
</script>

</body>
</html>

