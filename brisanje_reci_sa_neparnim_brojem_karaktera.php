<?php
require_once 'osnova/inicijalizacija.php';
$korisnik = new Korisnik();

if (!$korisnik->je_ulogovan_k()) 
{
	Preusmeri::na('registracija.php');
}
if(!($korisnik->ima_prava('admin')) )
{
	Preusmeri::na('index.php');
} 
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
	<title>Чишћење базе</title>
</head>
<body>
<div class="container">
	
	<?php
	echo napravi_heading($korisnik->podaci_k()->tip_korisnika, $korisnik->podaci_k()->id);
	?>
	
	<h2>Брисање свих речи са непарним бројем карактера</h2>

	<?php

	$bp_instanca = Baza_podataka::vrati_instancu();
	$bp_instanca->pronadji('reci_osmosmerke', array('rec', 'LIKE', '%')); 
	$niz_pretrage = $bp_instanca->rezultati_bp();
	$niz_pretrage = json_decode(json_encode($niz_pretrage), true);
	// print_r($niz_pretrage); - sve reci u nizu

	echo "<p>Листа свих речи које имају непаран број карактера: </p>"; 
	$neparne_reci = reci_sa_neparnim_br_karaktera($niz_pretrage);
	if (Input::postoji()) 
	{
		// print_r($neparne_reci);
		foreach ($neparne_reci as $br_reci=>$niz_polja_reci)
		{
			// print_r($br_reci);
			$bp_instanca->obrisi('reci_osmosmerke', array('rec', '=', $neparne_reci[$br_reci]['rec']));//$neparne_reci
			// echo "POSTOJI";
		}
		Preusmeri::na('brisanje_reci_sa_neparnim_brojem_karaktera.php'); // refresh stranicem 23. mart , a zasto ?XD
	}
	if($neparne_reci)
	{
		// print_r( $neparne_reci );
		echo("<table>");	 
		$i = 1;
		foreach ($neparne_reci as $np_rec) 
		{
			echo('<tr>'); 
				echo('<td>'); 
					echo $i . ".  "; 
					print_r($np_rec['rec']);  
				echo('</td>');
				$i++;
			echo('</tr>'); 
		}
		echo('</table>'); 
		echo('<tr>');
			echo('<form action="" method="post">');
				echo('<input type="submit" name="obrisi_sve_np_reci" value="Обришите све речи са непарним бројем карактера (са списка)">');
			echo ('</form>');
		echo('</tr>');
	} else {
		echo "<p1>У табели 'reci_osmosmerke' нема речи које имају непаран број карактера у себи!</p1>";
	}	
	
	echo "<br>" . "<p1>Ако је листа празна, онда је табела попуњена само ћириличним словима али и даље није урађен код за проверу осталих карактера као што су:  ; ' ! # ...  </p1>";

	?>
	
	<div id="content-wrap">
		<footer id="footer"><small>&copy; Copyright 2021.   Dimitrije Drakulić</small></footer>
	</div>
	
</div>
</body>
</html>


