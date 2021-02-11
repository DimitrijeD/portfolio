<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
</head>
<body>
	<div class="container">
		<ul>
			<li><a href="pocetna_stranica.php">Почетна страница</a></li>
			<li><a href="igraOsmosmerka.php">Игра осмосмерка</a></li>
		</ul>
		<?php
		require_once 'osnova/inicijalizacija.php';

		$korisnik = new Korisnik();

		if(!$korisnik->je_ulogovan_k())
		{
			Preusmeri::na('pocetna_stranica.php');
		}

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
						Preusmeri::na('pocetna_stranica.php');
					} 
					catch(Exeption $e){
						die($e->getMessage());
					}
				} else {
					foreach ($rez_validacije->sve_greske() as $greska)
					{
						echo $greska, '<br>';
					}
				}
			}
		}

		?>

		<form action="" method="post">
			<div>
				<label for="korisnicko_ime">Промените име корисника</label>
				<input type="text" name="korisnicko_ime" value="<?php echo ocisti($korisnik->podaci_k()->korisnicko_ime); ?>">

				<input type="submit" name="azuriranje"  value="Ажурирајте податке."> 
				<input type="hidden" name="token" value="<?php echo Token::napravi_t(); ?>">
			</div>
		</form>
	</div>
</body>
</html>
