<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
</head>
<body>
	<div class="container">
		<ul>
			<li><a href="igraOsmosmerka.php"> Игра осмосмерка </a></li>
			<li><a href="odjava.php"> Одјава </a></li>
	
	<?php
	require_once 'osnova/inicijalizacija.php';
	$korisnik = new Korisnik();

	if ($korisnik->je_ulogovan_k())
	{	
		?>
		<li><a href="profil.php?korisnik=<?php echo $korisnik->podaci_k()->id; ?>"> Профил </a></li> 
		</ul>
		<p> Добродошли <a href="profil.php?korisnik=<?php echo $korisnik->podaci_k()->id; ?>"><?php echo ocisti($korisnik->podaci_k()->korisnicko_ime); ?> </a>!</p> 
		<?php

		if($korisnik->ima_prava('admin'))
		{
			?> <li><a href="admin_stranica.php">Унос речи у осмосмерку</a></li></ul> <?php
			echo '<p>Ви сте администратор.</p>';
		}
	} else {
		echo '<p>Морате да се <a href="prijava.php">улогујете</a> или да се <a href="registracija.php">региструјете</a> !</p>';
	}
	// echo Sesija::vrati(Konfiguracija::vrati_konf('sesija/ime_sesije'));
	// print_r($_SESSION);
	?>
	
	</div>
</body>
</html>
