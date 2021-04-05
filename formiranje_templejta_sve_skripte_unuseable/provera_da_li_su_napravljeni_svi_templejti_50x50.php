<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
</head>
<body>
	<div class="container">
		<ul id="stranice">
			<li><a href="pocetna_stranica.php">Почетна страница</a></li>

			<li><a href="igraOsmosmerka.php">Игра осмосмерка</a></li>
			<li><a href="odjava.php">Одјава</a></li>
		</ul><br>
		<p1>Алати за одржавање валидности карактера у речима од којих се формирају осмосмерке</p1>
		<ul id="stranice">
			<li><a href="tabela_svih_reci_za_osmosmerke.php">Приказ свих речи од којих се праве осмосмерке</a></li> 
			<li><a href="brisanje_reci_sa_neparnim_brojem_karaktera.php"> Брисање свих речи са непарним бројем карактера </a></li>
			<li><a href="brisanje_reci_sa_latinicnim_karakterom.php"> Брисање свих речи са латиничним карактером </a></li>
		</ul>
		<p1>Други алати</p1>
		<ul id="stranice">
			<li><a href="skripte_za_testiranje/testiranje_rada_klase_osmosmerka_templejt.php"> Алат за тестирање рада класе Osmosmerka_tempejt </a></li>
			<li><a href="glomazni_unos_reci.php"> Алат за масовни/гломазни/bulk унос речи у табелу за попуњавање осмосмерки </a></li>
			<li><a href="kvadratna_spl.php"> Интерполација квадратним сплајном </a></li>
			<!-- pravljenje_templejta_osmosmerki.php -->
		</ul>	

		<?php
		require_once 'osnova/inicijalizacija.php';
		$korisnik = new Korisnik();
		
		Preusmeri::na('pocetna_stranica.php'); // nema vise sta da se radi sa skriptom, ali nek stoji jer nostalgia
		if( !($korisnik->ima_prava('admin')) )
		{
			Preusmeri::na('pocetna_stranica.php');
		} 
		/*

		ОВАЈ ТЕСТ СЕ ПОКАЗАО НЕУСПЕШНИМ УСЛЕД МЕМОРИЈСКИХ ОГРАНИЧЕЊА, НЕОПТИМИЗОВАНОГ КОДА И ОБИМНИХ ПЕТЉИ КОЈЕ РАДЕ СА ПОДАЦИМА. НЕ СКИДАТИ КОМЕНТАР!!!!!!!
		// petlja samo proverava da li su napravljeni svi fajlovi tejmplejta od 3x3 do 50x50 
		// fajlovi su uklonjeni iz sajta!
		
		for($r = 3; $r < 51; $r++)
		{
			for($k = 3; $k < 51; $k++)
			{
				// ako fajl ne postoji, zapisi koji ne postoje
				if( !file_exists('templejti_osmosmerke/' . $r . "x" .  $k . '.php') )
				{
					echo $r . $k . '.php' . "fajl ne postoji!" . "<br>";
				}
			}
		}
		*/

		?>
		
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
