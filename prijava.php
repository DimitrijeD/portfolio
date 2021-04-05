<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
	<title>Пријава корисника</title>
</head>
<body>
	<div class="container">
		<ul id="stranice">
			<li><a href="registracija.php">Региструјте се</a></li>
		</ul>

		<?php
		var_dump('kjhasdbkajb');
		require_once 'osnova/inicijalizacija.php';
		// var_dump(Sesija::postoji('home'));
		if(Sesija::postoji('home') AND Sesija::vrati('home') != ''){
			echo '<h2>' . Sesija::vrati('home') . '</h2>';
		}
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
						Preusmeri::na('index.php');
						// echo 'пријављен!';
					} else {
						echo '<div id="greske">';
						echo '<p>Неуспешна пријава!</p>';
						echo '</div>';
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


		<h2>Пријава корисника</h2>

		<form id="forma_o_i" action="" method="post">
			<div id="paralelno">
				<label for="email">Имејл адреса</label>
				<input type="text" name="email" id="email" autocomplete="off">
			</div>

			<div id="paralelno">
				<label for="sifra">Шифра</label>
				<input type="password" name="sifra" id="sifra" autocomplete="off">
			</div>

			<div id="paralelno">
				<label for="zapamti_me">
					<input type="checkbox" name="zapamti_me" id="zapamti_me"> Запамти ме
				</label>
			</div>

			<input type="hidden" name="token" value="<?php echo Token::napravi_t(); ?>">
			<input type="submit" value="Пријавите се">
		</form>

		<div id="content-wrap">
			<footer id="footer"><small>&copy; Copyright 2021.   Dimitrije Drakulić</small></footer>
		</div>
	
	</div>
</body>
</html>
