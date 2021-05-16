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
	<title>Админ-root</title>
</head>
<body> 
	<div class="container"> 

		<?php
		echo napravi_heading($korisnik->podaci_k()->tip_korisnika, $korisnik->podaci_k()->id);
		?>
		
		<h2>Унос речи у табелe за осмосмерку ( reci_osmosmerke_(broj_slova_u_reci) )</h2>
		<?php

		if (Input::postoji())
		{
			$niz_kriterijum_validacija = array(
					'rec' => array(
						'obavezno' => TRUE,
						'min' => 6,
						'max' => 24, // jer su sva cirilicna slova 2 bajta
						'jedinstven' => 'reci_osmosmerke'
					)
				);
			$validacija = new Validacija();
			$rez_validacije = $validacija->provera_unosa($_POST, $niz_kriterijum_validacija);
			// var_dump($_POST);
			if($rez_validacije->validacija_uspela())
			{
				$bp_instanca = Baza_podataka::vrati_instancu();
				
				$broj_slova_u_reci = mb_strlen($_POST['rec']);
				$tabela = "reci_osmosmerke_"."{$broj_slova_u_reci}";

				$bp_instanca->unesi($tabela, $_POST); 
				echo "<p>Успешна валидација, реч је унета у табелу: <strong>{$tabela}</strong><p>";
				echo "<p>Унета реч je: <strong>" . Input::vrati('rec') . " </strong>.<br>";

			} else {
				echo '<div id="greske">';
				foreach($rez_validacije->sve_greske() as $greska)
				{
					echo '<p>' . $greska, ' </p>';
				}
				echo '</div>';
			}
		}?>
		
		<h2> Форма </h2>
		<form action="" method="post" > <!-- accept-charset="Windows-1251" -->
			<div>
				<label for="rec">Унесите ћириличну реч</label>
				<input type="text" id="rec" name="rec" autocomplete="off" autofocus="autofocus" >
			</div>
			<input type="submit" value="Унеси реч">
		</form>
		
		<div id="content-wrap">
			<footer id="footer"><small>&copy; Copyright 2021.   Dimitrije Drakulić</small></footer>
		</div>	
		
	</div>
<script>
	if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
	}
</script>
</body>
</html>
