<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
</head>
<body>
	<div class="container">
		<ul>
			<li><a href="pocetna_stranica.php">Почетна страница</a></li>			
		</ul><br>

		<?php
		require_once 'osnova/inicijalizacija.php';

		$korisnik = new Korisnik();

		if(!$korisnik->je_ulogovan_k())
		{
			Preusmeri::na('pocetna_stranica.php');
		}

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
						echo "Ваша тренутна шифра је погрешна.";
					} else {
						$_so = Hes::so(32);
						$niz_azuriranja = array(
							'sifra' =>Hes::napravi(Input::vrati('nova_sifra'), $_so),
							't_so' => $_so
						);
						$korisnik->azuriraj_k($niz_azuriranja);

						Sesija::prikazi_jednom('home', 'Ваша шифра је промењена!');
						Preusmeri::na('pocetna_stranica.php');
					}
				} else {
					foreach($rez_validacije->sve_greske() as $greska){
						echo $greska, '<br>';
					}
				}
			}
		}
		?>

		<form action="" method="post">
			<div>
				<label for="trenutna_sifra">Тренутна шифра</label>
				<input type="password" name="trenutna_sifra" id="trenutna_sifra">
			</div>

			<div>
				<label for="nova_sifra">Нова шифра</label>
				<input type="password" name="nova_sifra" id="nova_sifra">
			</div>

			<div>
				<label for="nova_sifra_provera">Унесите нову шифру поново</label>
				<input type="password" name="nova_sifra_provera" id="nova_sifra_provera">
			</div>

			<input type="submit" value="Промените шифру">
			<input type="hidden" name="token" value="<?php echo Token::napravi_t(); ?>">

		</form>
	</div>
</body>
</html>
