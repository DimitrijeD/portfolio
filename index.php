<?php
require_once 'osnova/inicijalizacija.php';
$korisnik = new Korisnik();
if (!$korisnik->je_ulogovan_k()) 
{
	Preusmeri::na('registracija.php');
}

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
	<title>Почетна страница</title>
</head>
<body>
	<div class="container">

		<?php
		echo napravi_heading($korisnik->podaci_k()->tip_korisnika, $korisnik->podaci_k()->id);
		?>

		<h2> Почетна страница </h2>	

		<p style="padding:0 20px;margin: 0 20px;"> Добродошли 
			<a href="profil.php?korisnik=<?php echo $korisnik->podaci_k()->id; ?>" style="background-color: #d0e1e1;">
				<?php echo ocisti($korisnik->podaci_k()->korisnicko_ime); ?> 
			</a>
		</p> 

	<?php
	if (!$korisnik->je_ulogovan_k()) {
		echo '<p>Морате да се <a href="prijava.php">улогујете</a> или да се <a href="registracija.php">региструјете</a> !</p>';
	}
	if($korisnik->ima_prava('admin'))
	{
		echo '<p style="padding:0 20px;margin: 0 20px;">Ви сте администратор.</p>';
	}
	// echo Sesija::vrati(Konfiguracija::vrati_konf('sesija/ime_sesije'));
	// print_r($_SESSION);
	?>
	<br>
	<h3>Веб сајт покрећу бесплатне услуге <a href="https://www.heroku.com/home" target="_blank">Heroku</a> и <a href="https://remotemysql.com/index.html" target="_blank">Remote MySql</a>. Сајт служи да презентује пројекте (<i>портфолио</i>) на којима је аутор Димитрије Дракулић самостално радио. Следеће картице су линкови за те пројекте које можете погледати. </h3>

	<div id="pocetna_stranica">
		<a href="igraOsmosmerka.php">
			<div id="blok" style="border-top: solid #9999ff 2px;border-left: solid #9999ff 2px;">
				<p>Стандардна осмосмерка</p>
				<div id="opis">Формирање нових осмосмерки на основу димензија по жељи и опционалних речи које желите да буду унете.</div>
				<img src="slike/standardna_osmosmerka.jpg" alt="Слика стандардне осмосмерке">
			</div>
		</a>
		<a href="asimetricna_osmosmerka.php">
			<div id="blok" style="border-top: solid #9999ff 2px;border-right: solid #9999ff 2px;">
				<p>Асиметрична осмосмерка</p>
				<div id="opis">Формирање нових асиметричних осмосмерки на основу димензија, речи и поља која бирате по жељи.</div>
				<img src="slike/asimetricna_osmosmerka.jpg" alt="Слика асиметричне осмосмерке">
			</div>
		</a>
	</div>

	<div id="pocetna_stranica">
		<!-- <p>Квадратни сплајн</p>
		<div id="opis">Рачунање квадратног сплајна на основу познатих чворова кроз које он пролази.</div> -->
			<a href="kvadratna_spl.php">
				<div id="blok" style="border-bottom: solid #9999ff 2px;border-left: solid #9999ff 2px;">
					<p>Чворови</p>
					<div id="opis">Тачке кроз које пролази сплајн.</div>
					<img src="slike/cvorovi.jpg" alt="Слика чворова" style="width: 70%;">		
				</div>
			</a>	
			<a href="kvadratna_spl.php">
				<div id="blok" style="border-bottom: solid #9999ff 2px;border-right: solid #9999ff 2px;">
					<p>Квадратни сплајн</p>
					<div id="opis">Резултујући сплајн на основу чворова.</div>
					<img src="slike/splajn.jpg" alt="Слика сплајна са чворовима" style="width: 70%;">
				</div>
			</a>
			
	</div>

	<div id="content-wrap">
		<footer id="footer"><small>&copy; Copyright 2021.   Dimitrije Drakulić</small></footer>
	</div>	
	
	</div>
</body>
</html>
