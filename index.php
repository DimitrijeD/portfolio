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
		<ul id="stranice">
			<li><a href="index.php">Почетна страница</a></li>
			<li><a href="igraOsmosmerka.php"> Осмосмерка</a></li>
			<li><a href="kvadratna_spl.php"> Интерполација</a></li>
			<li><a href="asimetricna_osmosmerka.php">Асиметрична осмосмерка</a></li>
			<div class="dropdown">
				<div class="dropbtn">Korisnik</div>
					<div class="dropdown-content">
						<?php	
						if ($korisnik->je_ulogovan_k()) 
						{	?>		
						<a href="profil.php?korisnik=<?php echo $korisnik->podaci_k()->id; ?>"> Профил </a> 
						<?php } ?>						
						<a href="azuriranje.php"> Промени име </a>
						<a href="promeni_sifru.php"> Промени шифру </a>
					</div>
			</div>

			<?php			

			if( ($korisnik->ima_prava('admin')) ) // ako je korisnik admin, prikazi mu ostale linkove
			{	
			?>	
		
			<div class="dropdown">
				<div class="dropbtn">Алати за базу</div>
					<div class="dropdown-content">
						<a href="admin_stranica.php">Админ страница</a>						
						<a href="brisanje_reci_sa_neparnim_brojem_karaktera.php"> Брисање свих речи са непарним бројем карактера </a>
						<a href="brisanje_reci_sa_latinicnim_karakterom.php"> Брисање свих речи са латиничним карактером </a>						
						<a href="glomazni_unos_reci.php"> Алат за масовни/гломазни/bulk унос речи у табелу за попуњавање осмосмерки </a>
						<a href="test_tabele_osmosmerke.php"> Тест валидности табела за речи (reci_osm_N) </a>
					</div>
			</div>
			<div class="dropdown">
				<div class="dropbtn">Алати за осмосмерке</div>
					<div class="dropdown-content">
						<a href="to_do_list.php"> to_do_list </a>
						<a href="testiranje_rada_klase_osmosmerka_templejt.php"> Алат за тестирање рада класе Osmosmerka_tempejt </a>
						<a href="pravljenje_ogromnih_osmosmerki.php"> Страница за прављење огромних осмосмерки </a> 
					</div>
			</div>
			<?php } ?>
			<li style="float: right; margin: 0; padding: 0px 5px"><a style="margin: 10px; padding: 5px 10px 5px 5px" href="odjava.php">Одјава</a></li>	
		</ul>
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
	<h3>Веб сајт служи да презентује пројекте на којима је аутор Димитрије Дракулић самостално радио. Следеће картице су линкови за те пројекте на којима кожете погледати садржај и уносити податке у форме. </h3>

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
<!-- 	<div id="pocetna_stranica">
		<a href="#">
			<div id="blok">
			</div>
		</a>
	</div> -->

	<div id="content-wrap">
		<footer id="footer"><small>&copy; Copyright 2021.   Dimitrije Drakulić</small></footer>
	</div>	
	
	</div>
</body>
</html>
