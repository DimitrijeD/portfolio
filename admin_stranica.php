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
