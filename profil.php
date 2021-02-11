<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
</head>
<body>
<?php
/*Kad sredim ispisivanje podataka u tabele i grafike, na ovoj stranici ce korisnik moci da vidi statistiku resenih osm*/
require_once 'osnova/inicijalizacija.php';

if(!$id = Input::vrati('korisnik')){
	Preusmeri::na('pocetna_stranica.php');
} else {
	$korisnik = new Korisnik($id);
	if(!$korisnik->postoji_k())
	{
		Preusmeri::na(404);
	} else {
		$data = $korisnik->podaci_k();
		// print_r($data);
	}
	?>
	<div class="container">
		<ul>
			<li><a href="igraOsmosmerka.php">Игра осмосмерка</a></li>
			<li><a href="pocetna_stranica.php">Почетна страница</a></li>
			<li><a href="azuriranje.php">Ажурирајте податке</a></li>
			<li><a href="promeni_sifru.php">Промените шифру</a></li>
			<li><a href="odjava.php">Одјава</a></li>
		</ul>
		<p>Име корисника: <?php echo ocisti($data->korisnicko_ime); ?></p>
		<p>Ваша имејл адреса: <?php echo $data->email; ?></p>
		<?php 
} ?>
	</div>
</body>
</html>
