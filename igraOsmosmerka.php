<?php
require_once 'osnova/inicijalizacija.php';
$korisnik = new Korisnik();

if (!$korisnik->je_ulogovan_k()) 
{
	Preusmeri::na('registracija.php');
}

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
	<title>Игра осмосмерка</title>
	<script src="java_script/java_script_sve.js"> 
	</script>
</head>
<body>

<div id="container" class="container"> <!-- !!!!!!!!!!! -->
	<ul id="stranice">
			<li><a href="index.php">Почетна страница</a></li>
			<li><a href="igraOsmosmerka.php"> Осмосмерка</a></li>
			<li><a href="kvadratna_spl.php"> Интерполација</a></li>
			<li><a href="asimetricna_osmosmerka.php">Асиметрична осмосмерка</a></li>
			<div class="dropdown">
				<div class="dropbtn">Korisnik</div>
					<div class="dropdown-content">
						<?php	
						if ($korisnik->je_ulogovan_k())
						{	?>		
						<a href="profil.php?korisnik=<?php echo $korisnik->podaci_k()->id; ?>"> Профил </a> 
						<?php } ?>	
						<a href="azuriranje.php"> Промени име </a>
						<a href="promeni_sifru.php"> Промени шифру </a>
					</div>
			</div>

			<?php			

			if( ($korisnik->ima_prava('admin')) ) // ako je korisnik admin, prikazi mu ostale linkove
			{	
			?>	
		
			<div class="dropdown">
				<div class="dropbtn">Алати за базу</div>
					<div class="dropdown-content">
						<a href="admin_stranica.php">Админ страница</a>						
						<a href="brisanje_reci_sa_neparnim_brojem_karaktera.php"> Брисање свих речи са непарним бројем карактера </a>
						<a href="brisanje_reci_sa_latinicnim_karakterom.php"> Брисање свих речи са латиничним карактером </a>						
						<a href="glomazni_unos_reci.php"> Алат за масовни/гломазни/bulk унос речи у табелу за попуњавање осмосмерки </a>
						<a href="test_tabele_osmosmerke.php"> Тест валидности табела за речи (reci_osm_N) </a>
					</div>
			</div>
			<div class="dropdown">
				<div class="dropbtn">Алати за осмосмерке</div>
					<div class="dropdown-content">
						<a href="to_do_list.php"> to_do_list </a>
						<a href="testiranje_rada_klase_osmosmerka_templejt.php"> Алат за тестирање рада класе Osmosmerka_tempejt </a>
						<a href="pravljenje_ogromnih_osmosmerki.php"> Страница за прављење огромних осмосмерки </a> 
					</div>
			</div>
			<?php } ?>
			<li style="float: right; margin: 0; padding: 0px 5px"><a style="margin: 10px; padding: 5px 10px 5px 5px" href="odjava.php">Одјава</a></li>	
	</ul>
	<h2> Игра осмосмерка </h2>
	<details>
		<summary>Додатне информације</summary>
		<p>Само се једна осмосмерка прави што значи да неће увек бити: потпуна са решењем или са свим пољима попуњеним словима.</p>
		<p>Најмања осмосмерка која може да се формира је величине 3*3.</p>
		<p>Ако се унесу превелике вредности осмосмерке формираће се полупразна осмосмерка и потрајаће пар секунди.</p>			
		<p>Тренутно не постоји горње ограничење димензија осмосмерки.</p>
		<p>Алгоритам је оптимизован за ~ 15*15 до ~ 25*25.</p>
	</details>
	<!-- forma_o_i  - za osmosmerku i interpolaciju -->
	<form id="forma_o_i" action="" method="post">
		<div id="paralelno">
			<label for="red_velicina_osmosmerke">Унесите висину (<strong>ред</strong>) осмосмерке</label>
			<input type="text" name="red_velicina_osmosmerke" id="red_velicina_osmosmerke" autofocus="autofocus" autocomplete="off">			
		</div>
		<div id="paralelno">
			<label for="kolona_velicina_osmosmerke">Унесите ширину (<strong>колону</strong>) осмосмерке</label>
			<input type="text" name="kolona_velicina_osmosmerke" id="kolona_velicina_osmosmerke" autocomplete="off">
		</div>
		<div id="paralelno">
			<label for="reci_od_korisnika">Унесите <strong>речи</strong> које желите да буду у осмосмерци (опционално). Сваку реч одвојите зарезом</label>
			<input type="text" name="reci_od_korisnika" id="reci_od_korisnika" autocomplete="off">
		</div>

		<?php 
		if ($korisnik->ima_prava('admin')) 
		{
		?>

			<div id="paralelno">
				<input type="radio" id="prikazi_podatke" name="prikazi_podatke" value="true">
				<label id="prikazi_podatke" for="prikazi_podatke">Прикажи додатне податке</label>
			</div>

			<div id="paralelno">
				<input type="radio" id="prikazi_puteve" name="prikazi_puteve" value="true">
				<label id="prikazi_puteve" for="prikazi_puteve">Прикажи све путеве који пролазе кроз поље (onmouseover event)</label>
			</div>

		<?php 
		} 
		?>

		<input type="submit" name="napravi_osmosmerku" value="Направи осмосмерку">
	</form>

	<?php

	if (Input::vrati('napravi_osmosmerku')) 
	{
		// kastovanje promenljivih na int
		$red = (int)Input::vrati('red_velicina_osmosmerke');
		$kolona = (int)Input::vrati('kolona_velicina_osmosmerke');
		$prikazi_puteve = null; // bice over written kasnije, cisto da n bude notuice
		
		$niz_kriterijum_validacija = array(
			'red_velicina_osmosmerke' => array(
				'obavezno' => TRUE,
				'min_osmosmerka' => 3				
			),
			'kolona_velicina_osmosmerke' => array(
				'obavezno' => TRUE,
				'min_osmosmerka' => 3				
			),	
			'reci_od_korisnika' => array(
				'obavezno' => FALSE,
				// 'max_broj_reci' => ??, // da bi se znao max ogranicenje reci, mora se znati koja je dimenzija, komplikovano je...
				'max_broj_reci' => 15, // ... nek ovako bude
				'red' => $red,
				'kolona' => $kolona,
				// bool vrednost bi trebala da bude promenljiva u zavisnosti da li se prave cirilicne ili latinicne osmosmerke
				// za sad mogu samo ciriliocne, verovatno ce tako zauvek i ostati
				'cirilica' => TRUE 
			)			
		);
		
		$validacija = new Validacija();
		$rez_validacije = $validacija->provera_unosa($_POST, $niz_kriterijum_validacija);

		if($rez_validacije->validacija_uspela())
		{
			$reci_od_korisnika = $validacija->vrati_reci_od_korisnika();
			$tip_osmosmerke = "standardna";

			$osmosmerka = new Osmosmerka($red, $kolona, $reci_od_korisnika, $korisnik->podaci_k()->id, $tip_osmosmerke);
			$osmosmerka_niz = $osmosmerka->popunjavanje_sa_korisnickim_recima();
			// var_dump($GLOBALS['unete_reci_sa_putevima'] );
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
			$korisnik->napravio_osmosmerku();

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

<script> 
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

