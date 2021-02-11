<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
</head>
<body>
	<div class="container">

<?php
require_once 'osnova/inicijalizacija.php';

$korisnik = new Korisnik();
if ($korisnik->je_ulogovan_k()){
	Preusmeri::na('pocetna_stranica.php');
} 

// ako postoji $_GET ili $_POST vraca TRUE 
if (Input::postoji())
{
	if (Token::proveri_t(Input::vrati('token')))
	{
		// var_dump(Input::vrati('token'));
		$niz_kriterijum_validacija = array(
				'email' => array(
					'obavezno' => TRUE,
					'min' => 2,
					'max' => 20,
					'jedinstven' => 'korisnici' // kako ne bi bilo vise korisnika sa istim emailom
				),
				'sifra' => array(
					'obavezno' => TRUE,
					'min' => 6
				),
				'sifra_za_proveru' => array(
					'obavezno' => TRUE,
					'su_jednaki' => 'sifra'
				),
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
			$korisnik = new Korisnik();

			$_so = Hes::so(32);
			
			try {
				$korisnik->napravi_k(array(
					'email' => Input::vrati('email'),
					'sifra' => Hes::napravi(Input::vrati('sifra'), $_so),
					't_so' => $_so,
					'korisnicko_ime' => Input::vrati('korisnicko_ime'),
					'pridruzio_se' => date('Y-m-d H:i:s'),
					'tip_korisnika' => 1
				));
				if (!$korisnik->ima_prava('admin')){
					Sesija::prikazi_jednom('home', 'Успешно сте се регистровали и можете се пријавити!');
					Preusmeri::na('pocetna_stranica.php');
				} else {
					echo "Направељен је нови корисник";
				}
			} catch(Exception $e){
				die($e->getMessage());
			}
		} else {
			foreach($rez_validacije->sve_greske() as $greska){
				echo "$greska, '<br>";
			}
		}
	}
}
?>

<ul>
	<li><a href="prijava.php">Пријавите се</a></li>
</ul> <br><br><br>
	<p>Регистрација корисника</p>
	<form action="" method="post">
		<div>
			<label for="email">Имејл адреса</label>
			<input type="text" name="email" id="email" value="<?php echo ocisti(Input::vrati('email')); ?>" autocomplete="off">
		</div>

		<div>
			<label for="sifra">Шифра</label>
			<input type="password" name="sifra" id="sifra">
		</div>

		<div>
			<label for="sifra_za_proveru">Упишите шифру поново</label>
			<input type="password" name="sifra_za_proveru" id="sifra_za_proveru">
		</div>

		<div>
			<label for="korisnicko_ime">Име корисника</label>
			<input type="text" name="korisnicko_ime" value="<?php echo ocisti(Input::vrati('korisnicko_ime')); ?>" id="korisnicko_ime">
		</div>

		<input type="hidden" name="token" value="<?php echo Token::napravi_t(); ?>">
		<input type="submit" value="Региструјте се!"> 
	</form>
</div>
</body>
</html>