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
			<li><a href="kvadratna_spl.php"> Интерполација квадратурном формулом </a></li>
			<!-- pravljenje_templejta_osmosmerki.php -->
		</ul>	

		<?php
		require_once 'osnova/inicijalizacija.php';
		$korisnik = new Korisnik();

		if( !($korisnik->ima_prava('admin')) )
		{
			Preusmeri::na('index.php');
		} 
		ini_set('max_execution_time', '0');
		// ini_set('memory_limit', '100M');


		
		$niz_fajlova_koji_nedostaju = array();

		for($r = 3; $r <= 50; $r++)
		{
			for($k = 20; $k <= 21; $k++)
			{	

				// ako fajl ne postoji, zapisi koji ne postoje
				if( file_exists('templejti_osmosmerke/' . $r . "x" .  $k . '.php') )
				{
					require_once 'templejti_osmosmerke/' . $r . "x" .  $k . '.php';
					$ukupan_br_puteva = 0;
					for($i = 3; $i <= 12; $i++)
					{
						if( isset($niz_svih_puteva_za_fajl[$i]) )
						{
							$ukupan_br_puteva = $ukupan_br_puteva + count($niz_svih_puteva_za_fajl[$i]);
						}
					}

					$br_puteva_klasa = new Testiranje_formule_broja_puteva_u_osm($r, $k);
					$br_puteva_rez_k = $br_puteva_klasa->izracunaj_broj_puteva();

					if($br_puteva_rez_k == $ukupan_br_puteva)
					{
						// sve je ok
					} else {
						echo "<br>" . "-------------------------------------------------------------------------------------------------------------" . "<br>";	
						echo "Величина осмосмерке је " . $r . " * " . $k . "<br>";
						echo "Укупан број путева добијен класом (математичком формулом) Testiranje_formule_broja_puteva_u_osm је: " .  "<br>" . $br_puteva_rez_k . "<br>";
						echo "Број путева у библиотеци: " . "<br>" . $ukupan_br_puteva;
						echo "<br>" . "-------------------------------------------------------------------------------------------------------------" . "<br><br>";
					}
					// ocisti memoriju
					unset($br_puteva_klasa);
					unset($br_puteva_rez_k);
					unset($niz_svih_puteva_za_fajl);
				} else {
					$niz_fajlova_koji_nedostaju[] = $r . "x" . $k . '.php';
				}

			}	
		}	

		// ispisi na ekranu koji fajlovi nedostaju
		if(!empty($niz_fajlova_koji_nedostaju))
		{
			foreach ($niz_fajlova_koji_nedostaju as $key => $value) 
			{
				echo "<br>" . $value;
			}
		} else {
			echo "nema gresaka!";
		}	

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
