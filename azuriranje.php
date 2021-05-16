<?php
require_once 'osnova/inicijalizacija.php';
$korisnik = new Korisnik();
if(!$korisnik->je_ulogovan_k())
{
	Preusmeri::na('index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
	<title>Промена имена корисника</title>
</head>
<body>
	<div class="container">
		
		<?php
		echo napravi_heading($korisnik->podaci_k()->tip_korisnika, $korisnik->podaci_k()->id);
		?>

		<?php

		if (Input::postoji()) 
		{
			if( Token::proveri_t( Input::vrati('token') ) )
			{
				$niz_kriterijum_validacija = array(
					'korisnicko_ime' => array(
						'obavezno' => TRUE,
						'min' => 2,
						'max' => 50
						)
					);
				$validacija = new Validacija();
				$rez_validacije = $validacija->provera_unosa($_POST, $niz_kriterijum_validacija);
			
				if($rez_validacije->validacija_uspela())
				{
					try {
						$korisnik->azuriraj_k(array(
							'korisnicko_ime' => Input::vrati('korisnicko_ime')
							));
						Sesija::prikazi_jednom('home', 'унети подаци су ажурирани.');
						Preusmeri::na('index.php');
					} 
					catch(Exeption $e){
						die($e->getMessage());
					}
				} else {
					echo '<div id="greske">';
					foreach($rez_validacije->sve_greske() as $greska)
					{
						echo '<p>' . $greska, ' </p>';
					}
					echo '</div>';
				}
			}
		}

		?>

		<form id="forma_o_i" action="" method="post">
			<div id="paralelno">
				<label for="korisnicko_ime">Промените име корисника</label>
				<input type="text" name="korisnicko_ime" value="<?php echo ocisti($korisnik->podaci_k()->korisnicko_ime); ?>">
			</div>
			
			<input type="submit" name="azuriranje"  value="Ажурирајте податке."> 
			<input type="hidden" name="token" value="<?php echo Token::napravi_t(); ?>">
			
		</form>
		
		<div id="content-wrap">
			<footer id="footer"><small>&copy; Copyright 2021.   Dimitrije Drakulić</small></footer>
		</div>
		
	</div>
</body>
</html>
