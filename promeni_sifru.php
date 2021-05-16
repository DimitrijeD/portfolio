<?php
require_once 'osnova/inicijalizacija.php';
$korisnik = new Korisnik();
if(!$korisnik->je_ulogovan_k()){
	Preusmeri::na('index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
	<title>Промените шифру</title>
</head>
<body>
	<div class="container">

		<?php
		echo napravi_heading($korisnik->podaci_k()->tip_korisnika, $korisnik->podaci_k()->id);
		?>
		
		<h2>Промените шифру</h2>
		
		<?php

		if(Input::postoji())
		{
			if(Token::proveri_t(Input::vrati('token')))
			{
				$niz_kriterijum_validacija = array(
					'trenutna_sifra' => array(
						'obavezno' => TRUE,
						'min' => 6
					),
					'nova_sifra' => array(
						'obavezno' => TRUE,
						'min' => 6
					),
					'nova_sifra_provera' => array(
						'obavezno' => TRUE,
						'min' => 6,
						'su_jednaki' => 'nova_sifra'
					)
				);
				$validacija = new Validacija();
				$rez_validacije = $validacija->provera_unosa($_POST, $niz_kriterijum_validacija);

				if($rez_validacije->validacija_uspela())
				{
					if(Hes::napravi(Input::vrati('trenutna_sifra'), $korisnik->podaci_k()->t_so) !== $korisnik->podaci_k()->sifra)
					{
						echo '<div id="greske">';
						echo "<p>Ваша тренутна шифра је погрешна.</p>";
						echo '</div>';
					} else {
						$_so = Hes::so(32);
						$niz_azuriranja = array(
							'sifra' =>Hes::napravi(Input::vrati('nova_sifra'), $_so),
							't_so' => $_so
						);
						$korisnik->azuriraj_k($niz_azuriranja);

						Sesija::prikazi_jednom('home', '<p style="background-color:#66ff66; ">Ваша шифра је промењена!</p>');
						Preusmeri::na('index.php');
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
				<label for="trenutna_sifra">Тренутна шифра</label>
				<input type="password" name="trenutna_sifra" id="trenutna_sifra">
			</div>

			<div id="paralelno">
				<label for="nova_sifra">Нова шифра</label>
				<input type="password" name="nova_sifra" id="nova_sifra">
			</div>

			<div id="paralelno">
				<label for="nova_sifra_provera">Унесите нову шифру поново</label>
				<input type="password" name="nova_sifra_provera" id="nova_sifra_provera">
			</div>

			<input type="submit" value="Промените шифру">
			<input type="hidden" name="token" value="<?php echo Token::napravi_t(); ?>">

		</form>

		<div id="content-wrap">
			<footer id="footer"><small>&copy; Copyright 2021.   Dimitrije Drakulić</small></footer>
		</div>
		
	</div>
</body>
</html>
