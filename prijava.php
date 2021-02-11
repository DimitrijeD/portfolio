<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
</head>
<body>
<div class="container">

<?php
require_once 'osnova/inicijalizacija.php';

if(Input::postoji())
{
	if(Token::proveri_t(Input::vrati('token')))
	{
		$niz_kriterijum_validacija = array(
			'email' => array('obavezno' => TRUE),
			'sifra' => array('obavezno' => TRUE)
		);
		$validacija = new Validacija();
		$rez_validacije = $validacija->provera_unosa($_POST, $niz_kriterijum_validacija);

		if($rez_validacije->validacija_uspela())
		{
			$korisnik = new Korisnik();
			$zapamti_me = (Input::vrati('zapamti_me') ==='on') ? TRUE :FALSE;
			$prijava = $korisnik->prijavi_k(Input::vrati('email'), Input::vrati('sifra'), $zapamti_me);

			if($prijava)
			{
				Preusmeri::na('pocetna_stranica.php');
				// echo 'пријављен!';
			} else {
				echo "Неуспешна пријава!";
			}
		} else {
			foreach($rez_validacije->sve_greske() as $greska) {
				echo $greska, '<br>';
			}
		}
	}
}
?>
<ul>
	<li><a href="registracija.php">Региструјте се</a></li>
</ul><br><br><br>
<p>Пријава корисника</p>
<form action="" method="post">
	<div>
		<label for="email">Имејл адреса</label>
		<input type="text" name="email" id="email" autocomplete="off">
	</div>

	<div>
		<label for="sifra">Шифра</label>
		<input type="password" name="sifra" id="sifra" autocomplete="off">
	</div>

	<div>
		<label for="zapamti_me">
			<input type="checkbox" name="zapamti_me" id="zapamti_me"> Запамти ме
		</label>
	</div>

	<input type="hidden" name="token" value="<?php echo Token::napravi_t(); ?>">
	<input type="submit" value="Пријавите се">
</form>

</div>
</body>
</html>
