<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
</head>
<body>
	<div class="container">
		<ul>
			<li><a href="pocetna_stranica.php">Почетна страница</a></li>
			<li><a href="igraOsmosmerka.php"> Игра осмосмерка </a></li>
			<li><a href="odjava.php"> Одјава </a></li>
		</ul>
	
	<?php
	require_once 'osnova/inicijalizacija.php';
	$korisnik = new Korisnik();
	if( !($korisnik->ima_prava('admin')) ){
		Preusmeri::na('pocetna_stranica.php');
	}
// ----------------------------------------------------------------------------------------------------------------------
	$bp_instanca = Baza_podataka::vrati_instancu();
	$ukupan_broj_reci = 0;
	echo "test za proveru da li u tabelama reci_osm_N postoje reci koje nisu N duzine u slucaju da nisam dobro razdvojio tabelu reci_osmosmerke";
	for($n = 3; $n <= 12; $n++)
	{
		$tabela = "reci_osmosmerke_"."{$n}";
		$bp_instanca->pronadji($tabela, array('rec', 'LIKE', '%')); 
		$niz_pretrage = $bp_instanca->rezultati_bp();
		$niz_pretrage = json_decode(json_encode($niz_pretrage), true);
		$broj_reci_koje_pripadaju = 0;

		echo "<br>";
		echo "Tabela {$tabela}";

		for($rec = 0; $rec < count($niz_pretrage); $rec++)
		{
			if( mb_strlen($niz_pretrage[$rec]['rec']) != $n){
				echo "<br>" . $niz_pretrage[$rec]['rec'] . "-ova rec ne pripada ovoj tabeli" . "<br>";
			} else {
				$broj_reci_koje_pripadaju++;
			}
		}
		$ukupan_broj_reci = $ukupan_broj_reci + $broj_reci_koje_pripadaju;
		echo "<br>"."U tabeli ima {$broj_reci_koje_pripadaju} reci, proveriti u phpmyadmin da li ovaj broj odgovara pripadajucoj tabeli za konacnu proveru"."<br>";
		echo "<br>";
		echo "-------------------------------------------------------------";
		echo "<br>";
	}
	echo "<br>";
	echo "-------------------------------------------------------------";
	echo "<br>";
	echo "Ukupan broj reci od kojih se prave osmosmerke je {$ukupan_broj_reci}"; // isti kardinalitet kao i reci_osmosmerke. GG

// ----------------------------------------------------------------------------------------------------------------------
	// kod za razdvajanje tabele reci_osmosmerke na 10 tabela u kojima su reci iste duzine
	/*
	$bp_instanca->pronadji('reci_osmosmerke', array('rec', 'LIKE', '%')); 
	$niz_pretrage = $bp_instanca->rezultati_bp();
	$niz_pretrage = json_decode(json_encode($niz_pretrage), true);

	for($rec = 0; $rec < count($niz_pretrage); $rec++)
	{

		$duzina_reci = mb_strlen($niz_pretrage[$rec]['rec']);
		if($duzina_reci === 12)
		{
			// echo $rec . ". " . $niz_pretrage[$rec]['rec'] . "<br>";
			$bp_instanca = Baza_podataka::vrati_instancu();
			$bp_instanca->unesi('reci_osmosmerke_12', array('rec'=>$niz_pretrage[$rec]['rec'])); 
		}
	}
	*/
// ----------------------------------------------------------------------------------------------------------------------
	/*	
	echo "Reči sa 4 vezana suglasnika u sebi (na bilo kom mestu): " . "<br>";
	$br_test = 0;
	for($rec = 0; $rec < count($niz_pretrage); $rec++ )
	{
		for($pozicija_u_reci = 0; $pozicija_u_reci < mb_strlen($niz_pretrage[$rec]['rec']); $pozicija_u_reci++ )
		{
			if(isset($niz_pretrage[$rec]['rec'][$pozicija_u_reci + 1]))
			{
				var_dump($niz_pretrage[$rec]['rec'][$pozicija_u_reci].$niz_pretrage[$rec]['rec'][++$pozicija_u_reci] );
				if(  $niz_pretrage[$rec]['rec'][$pozicija_u_reci].$niz_pretrage[$rec]['rec'][$pozicija_u_reci+1] != "а" AND 
				     $niz_pretrage[$rec]['rec'][$pozicija_u_reci].$niz_pretrage[$rec]['rec'][$pozicija_u_reci+1] != "е" AND 
				     $niz_pretrage[$rec]['rec'][$pozicija_u_reci].$niz_pretrage[$rec]['rec'][$pozicija_u_reci+1] != "и" AND 
				     $niz_pretrage[$rec]['rec'][$pozicija_u_reci].$niz_pretrage[$rec]['rec'][$pozicija_u_reci+1] != "о" AND 
				     $niz_pretrage[$rec]['rec'][$pozicija_u_reci].$niz_pretrage[$rec]['rec'][$pozicija_u_reci+1] != "у"  
				    )
				{
					$br_test++;
					if($br_test > 3)
					{
						echo "<br>" . "reč sa 4 vezana suglasnika je: " . $niz_pretrage[$rec]['rec'] . "<br>";
					}
				} 
				$br_test = 0;
								
			}
			$pozicija_u_reci++;
		}
		
	}
	*/
// ----------------------------------------------------------------------------------------------------------------------
	/*
	echo "<p>Табела <b>свих речи</b> од којих се прави осмосмерка</p>";
	echo("<table>");
	echo('<tr>');
		echo('<th>ID</th>');
		echo('<th>rec</th>');
		echo('<th>brojac_uspesnih_unosa</th>');
		echo('<th>brojac_neuspesnih_unosa</th>');
	echo('</tr>');

	foreach ($niz_pretrage as $rec) 
	{
		echo('<tr>'); 
			echo('<td>'); 
				print_r($rec['id']);  
			echo('</td>');
			echo('<td>'); 
				print_r($rec['rec']);  
			echo('</td>');
			echo('<td>'); 
				print_r($rec['brojac_uspesnih_unosa']);  
			echo('</td>');
			echo('<td>'); 
				print_r($rec['brojac_neuspesnih_unosa']);  
			echo('</td>');
		echo('</tr>'); 
	}
	echo('</table>'); 
	echo "<br>";
	echo "<p1>Укупан број речи у табели 'reci_osmosmerke' je:  </p1>";
	print_r(count($niz_pretrage));
	echo "<br>";
	*/

	?>

	</div>
</body>
</html>
