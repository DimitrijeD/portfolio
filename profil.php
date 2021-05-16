<?php
require_once 'osnova/inicijalizacija.php';
if(!$id = Input::vrati('korisnik')){
	Preusmeri::na('index.php');
} else {
	$korisnik = new Korisnik($id);
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
	<title>Ваш профил</title>
</head>
	<body>
		<div class="container">

			<?php
			echo napravi_heading($korisnik->podaci_k()->tip_korisnika, $korisnik->podaci_k()->id);
			?>
			
			<h2> Ваш профил </h2>

			<?php
			
			if(!$korisnik->postoji_k())
			{
				Preusmeri::na(404);
			} else {
				$data = $korisnik->podaci_k();
				// print_r($data);
			}
			?>

			<p>Име корисника: <?php echo ocisti($data->korisnicko_ime); ?></p>
			<p>Ваша имејл адреса: <?php echo $data->email; ?></p>
			
			<div id="content-wrap">
				<footer id="footer"><small>&copy; Copyright 2021.   Dimitrije Drakulić</small></footer>
			</div>
		
		</div>
</body>
</html>
