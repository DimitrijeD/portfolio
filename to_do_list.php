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

		<?php
		echo napravi_heading($korisnik->podaci_k()->tip_korisnika, $korisnik->podaci_k()->id);
		?>
		
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
