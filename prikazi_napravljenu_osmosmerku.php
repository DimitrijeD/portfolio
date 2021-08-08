<?php
require_once 'osnova/inicijalizacija.php';
$korisnik = new Korisnik();

if( !($korisnik->je_ulogovan_k() ) )
{
	Preusmeri::na('pocetna_stranica.php');
} 
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="./css/stil.css">
	</head>

<body>
	<div class="container">
		<?php
		echo napravi_heading($korisnik->podaci_k()->tip_korisnika, $korisnik->podaci_k()->id);
		?>

		<h2>Приказ направљених осмосмерки</h2>

		<?php

		$red_tabele = array('id'=> 3, 'id_korisnika'=> 2, 'reci_osmosmerke'=>"вид/зид/миш/ров/", 'niz_osmosmerke'=>"видзидмишров", 'unet_red'=> 4, 'unet_kolona'=> 3, 'resenje_osmosmerke'=>"нема");

		echo ( napravi_tabelu( formiraj_osmosmerku_iz_baze($red_tabele) ) );
		echo "Решење ове осмосмерке је било: " . "<b>" . $red_tabele['resenje_osmosmerke'] . "</b>" . "<br>";
		
		?>
		
	</div>

<script>
	if ( window.history.replaceState ) 
	{
		window.history.replaceState( null, null, window.location.href );
	}
</script>
</body>
</html>
