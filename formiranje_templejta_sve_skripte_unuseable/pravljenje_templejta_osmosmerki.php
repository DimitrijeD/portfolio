<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
</head>
<body>
	<div class="container">
		<ul id="stranice">
			<li><a href="index.php">Почетна страница</a></li>

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
		// kako neko ne bi slucajno otvorio stranicu
		Preusmeri::na('index.php');
		if( !($korisnik->ima_prava('admin')) )
		{
			Preusmeri::na('index.php');
		} 
		/*

		Petlja pravi novi fajl, u fajlu templejti_osmosmerke, ako on ne postoji u njemu.
		Sadrzaj fajla je podatak niza svih puteva iz klase Osmosmerka_templejt
		sa strukturom:
		niz[duzine puteva od 3 do 13] [svi putevi duzine N][r/k] 0 za red, 1 za kolonu

		//////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////// NE DIRATI I NE CACKATI PO OVOM KODU! ////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////

		ini_set('max_execution_time', '0'); // uklanja vremensko ogranice rada skripte
		$broj_napravljenih = 0;
		$vec_postoji = 0;
		for($r = 3; $r < 51; $r++)
		{
			for($k = 3; $k < 51; $k++)
			{
				$sacuvaj_templejt_osmosmerke = new Sacuvaj_templejt_osmosmerke($r,$k);
				if( $sacuvaj_templejt_osmosmerke->da_li_postoji_fajl()) 
				{
					$broj_napravljenih++;
				} else
				{
					$vec_postoji++;
				}

			}
		}
		echo "Broj novo napravljenih fajlova : " . $broj_napravljenih . "<br>";
		echo "Broj pokusaja da se napravi fajl, ali vec postoji tako da se nece praviti je: " . $vec_postoji . "<br>";

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
