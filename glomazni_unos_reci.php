<?php
require_once 'osnova/inicijalizacija.php';
$korisnik = new Korisnik();

if (!$korisnik->je_ulogovan_k()) 
{
	Preusmeri::na('registracija.php');
}
if( !($korisnik->ima_prava('admin')) ){
	Preusmeri::na('index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
	<title>Унос речи из датотеке</title>
</head>
<body>
	<div class="container">
		
		<?php
		echo napravi_heading($korisnik->podaci_k()->tip_korisnika, $korisnik->podaci_k()->id);
		?>

		<h2> Унос речи из датотеке </h2>
		<p>Упутство: У форму уписати назив '.txt' документа у ком се налази текст из ког ће се преузети само речи и унети у базу података. Документ се мора налазити у фајлу: "tekstovi_za_popunjavanje_baze_recima" и његов назив мора бити исправно уписан. Пазите које писмо користите приликом уписа назива документа у форму. Тренутно је дозвољен рад само са латиничним писмом, тј. текст у документу мора бити у латиници да би се успешно унелe речи у базу, док ће ћириличне речи прескочити.<p>
		<p1>Напомена: користити ову страницу са опрезом. Прихватањем масовног усноса речи из текст документа може негативно утицати на квалитет направљених осмосмерки. Документ који унесете у форму мора бити на српском језику!</p1>

		<?php
	
		if (Input::postoji()  ) //file_exists(Input::vrati('dokument'))
		{
			$prvi_deo_puta = "tekstovi_za_popunjavanje_baze_recima/"; 
			$ime_dokumenta = Input::vrati('dokument');

			$extenzija = ".txt";
			$put_dokumenta = $prvi_deo_puta.$ime_dokumenta.$extenzija;
			
			if(!file_exists($put_dokumenta) )
			{
				?> <br><p>Име документа које сте унели не постоји у фајлу 'tekstovi_za_popunjavanje_baze_recima'. Прочитајте поново упутство и пробајте опет.</p><br> <?php
				exit();
			}
			
			// bez praznih elemenata u nizi, bez reci kracih od 5 karaktera (jer ima previse kratkih reci, pa da se izbalansira odnos duzih i kracih reci), 
			// a u validaciji ce da ukloni reci vece od 12
			$niz_svih_reci_dokumenta =  unos_reci_za_osmosmerke_iz_fajla( file_get_contents($put_dokumenta) );

			if (empty($niz_svih_reci_dokumenta)) 
			{
				?>  <div id="greske">
						<p>Ниједна реч није припремљена за унос. Могући разлози могу бити:</p><br>
						<p>Документ није .txt формата.</p>
						<p>Документ нема никакав текст у себи.</p>
						<p>Документ има текст у себи али није сачуван.</p>
						<p>Ниједна реч у том тексту није валидна што се може десити ако је текст лоше конвертован из неког другог формата (PDF). Proverite da li je tekst ispravan. </p>
					</div>
				<?php
				exit();
			}
			
			// print_r($niz_svih_reci_dokumenta);

			$broj_unetih_reci = 0;
			$unete_reci = array();
			$neuspele = array();

			for($kljuc_reci = 0; $kljuc_reci < count($niz_svih_reci_dokumenta); $kljuc_reci++ )
			{
				// odlucivanje u koju tabelu posto za svaku duzinu reci od 3 do 12 postoji zasebna tabela
				$duzina_reci = mb_strlen($niz_svih_reci_dokumenta[$kljuc_reci]['rec']);
				$tabela_za_reci = 'reci_osmosmerke_' . $duzina_reci; 

				$niz_kriterijum_validacija = array(
					'rec' => array(
						'obavezno' => TRUE,
						'min' => 6,
						'max' => 24, // jer su sva cirilicna slova 2 bajta
						'jedinstven' => $tabela_za_reci
					)
				);

				$validacija = new Validacija();
				$rez_validacije = $validacija->provera_unosa($niz_svih_reci_dokumenta[$kljuc_reci], $niz_kriterijum_validacija);

				if( $rez_validacije->validacija_uspela() )
				{
					$bp_instanca = Baza_podataka::vrati_instancu();
					
					// unos reci sa imenom dokumenta iz kog je ta rec uneta
					$red_tabele = array('rec'=>$niz_svih_reci_dokumenta[$kljuc_reci]['rec'], 'tip_unosa'=>$ime_dokumenta);
					$bp_instanca->unesi($tabela_za_reci, $red_tabele);

					//ako nije bilo gresaka u upitu
					if (! $bp_instanca->greska_u_pretrazi() )
					{
						$broj_unetih_reci++;
						$unete_reci[] = $niz_svih_reci_dokumenta[$kljuc_reci]['rec'];
					}

				} else 
				{
					$neuspele[$kljuc_reci] = array($niz_svih_reci_dokumenta[$kljuc_reci]['rec'], $rez_validacije->sve_greske() );
				}
			}

			if($broj_unetih_reci)
			{
				echo "<br>". "Број успешно унетих речи је: {$broj_unetih_reci} " . "<br>";
				echo "Унете речи су: " . "<br>";
				foreach ($unete_reci as $key => $value) 
				{
					echo $value . ", ";
				}
					
			} else {
				echo '<div id="greske">';
				echo "<br>" . "<br>" . "<br>". "<p>Ниједна реч није унета у базу!" . "</p>"; 
				foreach ($neuspele as $kljuc_niza_sve_za_rec => $niz_sve_za_rec) 
				{
					echo "<p>Реч: " . $neuspele[$kljuc_niza_sve_za_rec][0] . " , разлози:  </p>";
					foreach ($neuspele[$kljuc_niza_sve_za_rec][1] as $kljuc_razloga => $razlog) 
					{
						echo "<p>" . $neuspele[$kljuc_niza_sve_za_rec][1][$kljuc_razloga] . "</p>";
					}
					echo "</div>";
				}
			}
		}

		// https://www.php.net/manual/en/function.file-exists.php 
		?>
		
		<h2> Масовни унос речи у табелу за осмосмерку (reci_osmosmerke_N) </h2>
		<h2> Не сећам се да ли сам теситрао ову скрипту, todo!</h2>
		<form action="" method="post" >
			<div>
				<label for="dokument">Унесите име документа</label>
				<input type="text" id="dokument" name="dokument" autocomplete="on">
			</div>
			<!-- <input type="radio" name="pismo" value="ћирилица" checked="checked">Текст је у ћирили<br> -->

			<input type="submit" value="Масовно уношење речи у базу података">
		</form> 
		
		<div id="content-wrap">
			<footer id="footer"><small>&copy; Copyright 2021.   Dimitrije Drakulić</small></footer>
		</div>
		
	</div>

	<script>
	if ( window.history.replaceState ) 
	{
			window.history.replaceState( null, null, window.location.href );
	}
	</script>
</body>
</html>