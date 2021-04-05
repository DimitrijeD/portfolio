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
	<title>TO_DO_LIST</title>
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
		<h2> TO_DO_LIST </h2>
		
		<?php
				
		if( !($korisnik->ima_prava('admin')) )
		{
			Preusmeri::na('index.php');
		} 

		?>
		<div id="to_do_list">
			<ul>
				<p>Stranica igraOsmosmerka</p>
				<li>Nagomilan kod, php i js</li>
				<li>Validacija rešenja ne radi, tj radi samo kada se unese ispravno rešene</li>
				<li>Validacija u slucaju da se uklone sva polja asimetricne osmosmerke</li>
				<br>
			</ul>
			<ul>
				<p>Apsolutni debilizam sa moje strane</p>
				<li>Брисање свих речи са латиничним карактером и непарним бројем карактера</li>
				<li>ukaciti funkciju tabele da ispise sve podatke umesto onog show programa koji stoji tamo xd</li>			
				<br>
			</ul>
			<ul>
				<p>Za bazu</p>
				<li>Rucno unosenje reci u bazu, samo cirilicni karakteri, trenutno moze sve...</li>
				<li>Izgleda da fali i provera da li rec vec postoji u tabeli, garant je isto usled nedoradjenog rucnog unosa</li>
				<li>Test masovnog unosa u tabele 3...12</li>
				<li>Forma za uplodadovanje fajla iz kog se unose reči u tabele</li>
				<br>
			</ul>
			<ul>
				<p>Za prikaz i rešavanje osmosmerki</p>
				<li>Validacija unetih reči - validacija je komplikovana za osmosmerke manje od 12*12 i za broj unetih reči, možda ako dodam ograničenje</li>
				<li>Dorada CSS-a za prikaz osmosmerki kada su dimenzije prevelike da ona stane na ekran, tu verovatno treba SASS</li>
				<li>JS alat za onmouseover even prikazuje sve puteve koji prolaze kroz to polje, i dodati u test templejta</li>
				<br>
			</ul>
			<ul>
				<p>Za metodu interpolacije</p>
				<li>Sredjivanje UI-a interpolacije</li>
				<li>User input čvorova</li>
				<li>Grafički prikaz formiranog splajna, ovo je vec komplikovano</li>
				<li>Validacija unetih vrednosti čvorova</li>
				<li>Povećati broj zaokruživanja decimalnog broja radi povećanja preciznosti Gauss-Jordanove metode i smanjivanja šanse pojavljivanja NaN.</li>
				<br>
			</ul>
			<ul>
				<p>Logika popunjavanja osmosmerki</p>
				<li>Nedavno dodato ograničenje sa koliko drugih reči se reč duzine N moze seći se pokazalo kao slabo rešenje jer se reči srednjih dužina skoro uopšte ne unose(problem reči(putevi) u istim pravcima)</li>
				<li>U klasi templejt uneti metodu za raspoređivanje puteva </li>
				<li>Upravljanje brojem raznovrsnosti prvih unetih smerova puteva za templejte radi izbegavanja istosmernosti osmosmerki</li>
				<br>
			</ul>
			<ul>
				<p>Dokumentacija</p>
				<li>Doraditi formulu za izraunavanje </li>
				<br>
			</ul>
			<ul>	
				<p>Postaviti sajt na cloud</p>
				<li>????????????????????????</li>
				<br>
			</ul>
			<ul>
				<p>Ideje</p>
				<li>Human-validation: Nakon unosa dimenzija za osmosmerke, prikazati malu 3*3 osmosmerku da korisnik reši kako bi dokazao da je čovek a ne bot spammer</li>
				<br>
			</ul>
		</div>

		<div id="content-wrap">
			<footer id="footer"><small>&copy; Copyright 2021.   Dimitrije Drakulić</small></footer>
		</div>

	</div>
</body>
</html>
