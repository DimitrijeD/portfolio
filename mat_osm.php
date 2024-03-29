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
	<meta charset="UTF-8">
	<meta name="description" content="Matematika iza osmosmerke">
	<meta name="keywords" content="kombinatorika, osmosmerka, ukupan broj načina">
	<meta name="author" content="Dimitrije Drakulić">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
	
	<link rel="stylesheet" href="./css/stil.css">
	<link rel="stylesheet" href="./css/stil_mat.css">
	<title>Matematika iza osmosmerke</title>
</head>
<body>
	<div class="container">
		<?php
		// var_dump($korisnik->podaci_k()->tip_korisnika);
		echo napravi_heading($korisnik->podaci_k()->tip_korisnika, $korisnik->podaci_k()->id);
		?>
		

		<div style="width: 99%; margin: auto; background-color: #ffffff;">
			<h2> Matematika iza slagalice osmosmerke </h2>	
			<br>
			<p id="mat_sadrzaj">
				Pravljenje osmosmerki na ovom veb sajtu se zasniva na pristupu "brute force" - ovo su podaci, obradi ih. Da bi svaka slagalica bila drugačija, neophodno je da, napravljena slagalica, bude drugačija od ostalih čak i kad unesete iste dimenzije i opcionalne reči. To se postiže nedeterminisanim ponašanjem koda čija implementacija zahteva kompleksan pristup razvijanja algoritma.
			</p>

			<p id="mat_sadrzaj">
				Posmatrajući algoritam sa višeg nivoa apstrakcije, on imitira jednosmerno, dužinski ograničeno kretanje šahovske figure kraljica po šahovskoj tabli. U daljem tekstu, kretanje kraljice po tabli, postavljanje reči u osmosmerku i pojam put imaju apsolutno isto značenje za kontekst problematike kojom se rad bavi.
			</p>

			<img id="slika_mat" src="slike\mat_osm\slika1-1.png" style="width: 30%;">

			<p id="tekst_slike">Slika 1. Svi legalni potezi kraljice od tog polja tako da je najkraći potez dužine 3 polja</p>

			<p id="mat_sadrzaj">
				U sledećim poglavljima će biti objašnjeno kako se izračunava <b>ukupan broj načina</b> da se odigraju svi legalni potezi kraljicom na šahovskoj tabli pod definisanim ograničenjima:
			</p>

			<ul style="padding-top: 1px; margin-top: 1px;" id="mat_sadrzaj">
				<li id="mat_sadrzaj" style="padding-top: 1px; margin-top: 1px;" id="mat_sadrzaj">
					svaki potez je različit od svih ostalih, tj. imaju jedinstvenu kombinaciju početnih i krajnjih polja,
				</li>
				<li id="mat_sadrzaj">
					ne postoji nijedna druga figura na tabli koja <i>ometa</i> kretanje kraljice po tabli,
				</li>
				<li id="mat_sadrzaj"> 
					da su red i kolona šahovske table promenljive veličine (<i>minimalno 3 za obe veličine, dok nemaju maksimalno ograničenje</i>), 
				</li>
				<li id="mat_sadrzaj">
					svaki potez (<i>u daljem tekstu predstavlja sinonim pojmu <b>put</b> - path</i>) može biti bilo kojih dužina od 3 do 12 polja (<i>jer su reči, koje se koriste u osmosmerkama na ovom sajtu, nekih od tih dužina</i>).
				</li>
				<li id="mat_sadrzaj">
					svaki potez mora biti jedan od 8 jednosmernih pravaca (stoga <b>osmo</b><i>smerka</i>).
				</li>
			</ul>
			
			
			<br>
			<h3 style="border-top: 1px solid #a9b1ef; border-left: 1px solid #7e8ae7">Ukupan broj načina</h3>

			<p id="mat_sadrzaj">
				Postavljanje jedne reči u osmosmeru imitra kretanje šahovske figure kraljica (eng. queen, neki je nazivaju i dama) po praznoj šahovskoj tabli.
			</p>

			<!-- 
			<p id="mat_sadrzaj">
				Postavlja se sledeće pitanje: koliki je ukupan broj načina da se odigra potez sa kraljicom pod sledećim uslovima: 
			</p>

			
			<ul>
				<li id="mat_sadrzaj">za svako polje se mora odigrati potez kao da je početno (postaviti damu na svako polje i odigrati sve legalne poteze od tog polja),</li>
				<li id="mat_sadrzaj">minimalne dimenzije tabele su 3*3 dok nemaju maksimalno ograničenje,</li>
				<li id="mat_sadrzaj">validan potez predstavlja kretanje kraljice od nekog polja tabele, do drugog polja table tako da je najkraći potez jednosmerno udaljen 3 polja (trenutno polje + 2) a najduži 12 polja, i naravno sve dužine između.</li>
			</ul> 
			-->

			<p id="mat_sadrzaj">U daljem tekstu:</p>

			<ul style="padding-top: 1px; margin-top: 1px;">
				<li id="mat_sadrzaj" style="padding-top: 1px; margin-top: 1px;" id="mat_sadrzaj">skraćenica <b>r</b>, označava veličinu reda osmosmerke (ili šahovske table);</li>
				<li id="mat_sadrzaj">skraćenica <b>k</b>, označava veličinu kolone osmosmerke (ili šahovske table);</li>
				<li id="mat_sadrzaj">skraćenica <b>osm.</b> - osmosmerka;</li>
				<li id="mat_sadrzaj">pojam <b>put</b>, označava jedan jedinstven (legalan) potez kraljice ili jedno mesto u osm. u koje se može uneti reč.</li>
			</ul>

			<p id="mat_sadrzaj">
				Za vreme razvijanja aplikacije za pravljenje osm. , napravljen je matematički model za izračunavanje ukupnog broja načina da se reč (<i>pod definisanim ograničenjima</i>) upiše u osmosmerku. Pored toga što je služio kao test ispravnosti koda, on se može i prošiti prateći korake i posledice simetričnosti koje su objašnjene u sledećim poglavljima. Tako da ako imate sličan matematički problem koji trebate da rešite, nek vam ovaj sadržaj pomogne oko pristupa analize problema, njegovog razlaganja na jednostavnije probleme i na kraju, konačnog rešenja.   
			</p>

			<p id="mat_sadrzaj">
				Na <a href="/testiranje_rada_klase_osmosmerka_templejt.php" style="color: #007acc;"><i>sledećoj stranici</i></a> možete uneti veličine reda i kolone, kako bi vam se na ekranu prikazala celobrojna tablica koja prikazuje vrednosti ukupnog broja načina da kroz <b>to polje</b> prođe kraljica ili da se od svih kombinacija, reč upiše tako da prođe kroz to polje. U daljem tekstu nije opisano kako dobiti konkretne vrednosti nekog polja tabele jer je to druga tema koja će možda kasnije bili objašnjena na sajtu.   
			</p>			

			<img id="slika_mat" src="slike\mat_osm\Slika2.jpg" style="width: 27%;">

			<p id="tekst_slike">
				Slika 2. Pojam put u osmosmerci
			</p>


			<img id="slika_mat" src="slike\mat_osm\Slika3.jpg" style="width: 27%;">

			<p id="tekst_slike">Slika 3. Pojam put (potez) u šahu</p>

			<br>
			<h3 style="border-top: 1px solid #a9b1ef; border-left: 1px solid #7e8ae7">Analiza formiranja funkcije za izračunavanje ukupnog broja puteva</h3>

			<p id="mat_sadrzaj">Najočigledniji pristup je da se svaki smer posmatra kao zasebna funkcija, sa istim parametrima reda i kolone:</p>

			<p id="formula"><b>U</b>kupno(r, k) = gore + dole + levo + desno + gore_levo + gore_desno + dole_levo + dole_desno  <i>(1)</i></p>
			
			<ul>
				<li id="mat_sadrzaj"><b>U</b>kupno - broj svih puteva, funkcija red i kolone, koja ujedno predstavlja cilj pronalaska ovog teksta;</li>
				<li id="mat_sadrzaj">gore, dole, levo ... - ukupan broj puteva sa tim smerom;</li>
			</ul>

			<p id="mat_sadrzaj">U ostatku poglavlja će biti objašnjene:</p>

			<ul style="padding-top: 1px; margin-top: 1px;">
				<li id="mat_sadrzaj" style="padding-top: 1px; margin-top: 1px;">analize pronalaženja koeficijenata funkcija, a time i <i><b>U</b>kupno(r, k)</i> </li>
				<li id="mat_sadrzaj">pretpostavke na osnovu oučene simetrije ili matematičkog poretka,</li>
				<li id="mat_sadrzaj">testovi pretpostavki i izvedenih funkcija,</li>
				<!-- <li id="mat_sadrzaj">konačna funkcija na osnovu zbira ukupnih brojeva putava za individualne smerove.</li> -->
			</ul>

			<p id="mat_sadrzaj">
				Usled simetričnosti grafičke usmerenosti osm. , suprotni smerovi imaju isti broj puteva.	
				Ukupan broj puteva sa smerom dole je isti kao i ukupan broj puteva sa smerom gore (slika 4.). Ako se osmosmerka rotira za 180° , putevi koji su ranije bili smera dole, postaju smera gore. Tih novih smerova gore, ima isto onoliko koliko je bilo ranije (pre rotacije) smerova dole. Isto to važi za sve ostale <b>suprotne</b> smerove:
			</p>

			<img id="slika_mat" src="slike\mat_osm\Slika4.jpg">

			<p id="tekst_slike">Slika 4. Pre rotacije</p>

			<img id="slika_mat" src="slike\mat_osm\Slika5.jpg">

			<p id="tekst_slike">Slika 5. Posle rotacije</p>

			<p id="mat_sadrzaj">Time se funkcija pojednostavljuje:</p>

			<p id="formula">Ukupno = 2 * (U_smer_desno + U_smer_dole) + 2 * (U_dole_desno + U_gore_desno) <i>(2)</i></p>

			<p id="mat_sadrzaj">Može biti bilo koja kombinacija, trebala bi da daje isto rešenje za <b>U</b>kupno.</p>

			<br><br>
			<h3 style="border-top: 1px solid #a9b1ef; border-left: 1px solid #7e8ae7">U_smer_desno - Ukupan broj puteva sa smerom desno</h3>

			<p id="mat_sadrzaj">Mogu se podeliti u brojeve puteva sa dužinama 3, ... 12:</p>

			<p id="formula">U_smer_desno = red * ( br_dužina_3 + br_dužina 4 + . . . + br_dužina_12 )   <i>(3)</i></p>

			<p id="mat_sadrzaj">
				Tablice ispod su dobijene brojanjem sa primera osm. ukupnih brojeva puteva dozvoljenih dužina za promenljive veličine kolone <b>za samo jedan red</b>, što znači da množenjem veličine reda sa U_smer_desno se dobije konačni broj puteva smera desno.
			</p>

			<p id="tekst_tabele">Broj puteva dužine 3 polja</p>

			<img id="slika_mat" src="slike\mat_osm\Tabela1.png" style="width: 34%;">

			<p id="mat_sadrzaj">Uočava se da je broj puteva uvek za 2 manji od kolone.</p>

			<p id="formula">br_dužina_3 = k - 2  <i>(4)</i></p>

			<p id="mat_sadrzaj">Sledeće slike prikazuju šta vrednosti u tablici predstavljaju:</p>

			<img id="slika_mat" src="slike\mat_osm\Slika6.jpg">

			<p id="tekst_slike">Slika 6. Kad je kolona 3, može samo jedan jedinstven put (<i>smera desno</i>) dužine 3 da stane</p>

			<img id="slika_mat" src="slike\mat_osm\Slika7.jpg">

			<p id="tekst_slike">Slika 7. Kad je kolona 4, mogu dva jedinstvena put-a (<i>smera desno</i>) dužine 3 da stanu</p>

			<br><br>
			<p id="tekst_tabele">Broj puteva dužine 4 polja</p>

			<img id="slika_mat" src="slike\mat_osm\Tabela2.png" style="width: 34%;">

			<p id="mat_sadrzaj">
				Kod puteva dužine 4, već se pojavljuje slučaj da put ne može da stane u osm. čije su kolone veličine 3, što se podrazumeva. Druga razlika sa prethodnom tabelom je što su brojevi puteva uvek za <b>3</b> manji od veličine kolone, dok su u prethodnoj tabeli, uvek bili za <b>2</b> manji. 
			</p>

			<p id="formula">br_dužina_4 = k - 3  <i>(5)</i></p>

			<br><br>
			<p id="tekst_tabele">Broj puteva dužine 5 polja</p>

			<img id="slika_mat" src="slike\mat_osm\Tabela3.png" style="width: 34%;">

			<p id="mat_sadrzaj">Za 4 je manji broj puteva od dimenzije kolone tako da:</p>

			<p id="formula">br_dužina_5 = k - 4  <i>(6)</i></p>

			<br><br>
			<p id="mat_sadrzaj">
				Ako se pretpostavi da sve ostale dužine puteva prate isti logički poredak (<i>kako se ne bi pravile tablice za sve smerove i sve njihove dozvoljene dužine</i>), može se pretpostaviti, sa visokom sigurnošću, da je konačna <b>funkcija svih puteva smera desno</b> za bilo koju r*k osm.:
			</p>

			<img id="slika_mat" src="slike\mat_osm\Tabela4.png" style="width: 47%;">

			<p id="mat_sadrzaj">
				Pretpostavka 7 samo uzme sve moguće dužine puteva koje mogu da stanu u osm. te kolone, (kao na slikama 4 i 5) i pomnoži ih sa veličinom red što daje U_smer_desno - ukupan broj puteva za čitavu osm. ili šahovsku tablu dimenzija r*k.
			</p>

			<p id="mat_sadrzaj">Za sve osm. čija je k ≥ 12, funkcija se može skratiti:</p>

			<p id="formula">U_smer_desno = r * ( 10 * k - 65 )  <i>(8)</i></p>

			<p id="mat_sadrzaj">Strelice na gore ( ↑ ) označavaju dužinu funkcije za različite vrednosti kolone; primer:</p>

			<img id="slika_mat" src="slike\mat_osm\Slika8.jpg" style="width: 34%;">

			<p id="tekst_slike">Slika 8. Primer slučaja za k = 6  i  k = 11</p>

			<br>
			<h3 style="border-top: 1px solid #a9b1ef; border-left: 1px solid #7e8ae7">U_smer_dole - Ukupan broj puteva sa smerom dole</h3>

			<p id="mat_sadrzaj">
				Druga pretpostavka je da isti princip važi i za puteve smerova gore-dole usled simetričnosti koja se uočava nakon rotiranja osm. za 90°. 
				Jedina razlika sa smerom dole, jeste ta što rotacija za 90° uzrokuje da veličina reda, postaje veličina kolone :
			</p>

			<img id="slika_mat" src="slike\mat_osm\Tabela5.png" style="width: 47%;">

			<br>
			<h3 style="border-top: 1px solid #a9b1ef; border-left: 1px solid #7e8ae7">Broj puteva za dijagonalne smerove </h3>

			<p id="mat_sadrzaj">
				Za razliku od horizontalnih i vertikalnih smerova (gore, dole, levo i desno) koji zavise samo od veličine jedne dimenzije, tj. izračuna se ukupan broj puteva za jedan red ili kolonu, koji se pomnoži sa redom ili kolonom, dijagonalni smerovi zavise i od veličina red i kolone .<br>
				Ukupan broj puteva sa dijagonalnim smerom je:
			</p>

			<p id="formula">U_dij = dole_desno + dole_levo + gore_desno + gore_levo  <i>(11)</i></p>

			<p id="mat_sadrzaj">
				Broj puteva dole_desno i gore_levo se može pretpostaviti da je identičan iz ranije objašnjene simetrije. Isto to važi i za dole_levo sa gore_desno.<br>
				Usled toga, funkcija se skraćuje na:
			</p>

			<p id="formula">U_dij = 2 * dole_desno + 2 * dole_levo   <i>(12)</i></p>

			<p id="mat_sadrzaj">Pitanje preostaje, kako dobiti koeficijente za ove dve funkcije.</p>

			<br>
			<h3 style="border-top: 1px solid #a9b1ef; border-left: 1px solid #7e8ae7">U_dole_desno - Ukupan broj puteva smera dole desno</h3>
			<br>

			<p id="formula">U_dole_desno = dole_desno_duž_3 + dole_desno_duž_4 + ... + dole_desno_duž_12  <i>(13)</i></p>

			<p id="mat_sadrzaj">
				Za smer dole_desno, broj puteva dužine 3 ima sve više kako rastu i red i kolona. Za razliku od horizontalnih i vertikalnih, ovde je kontra-intuitivno formirati funkciju tako što će se pronaći broj puteva za svaku dijagonalu i množiti sa ukupnim brojem dijagonala jer što je kraća dijagonala, to manje puteva ima. Dakle očito postoji neka matematička šema koja se razlikuje od h/v smerova.
			</p>

			<p id="mat_sadrzaj">Ako bi se posmatrala tabela u kojoj su predstavljeni brojevi puteva dužina 3 za smer dole_desno:</p>

			<img id="slika_mat"  src="slike\mat_osm\Tabela6.png" style="width: 15%;">

			<p id="mat_sadrzaj">uočava se rast vrednosti iz kog se može formirati funkcija.</p>

			<p id="mat_sadrzaj">Na osnovu gornje tablice, popunjava se donja, prateći kvadratno rastući poredak:</p>

			<img id="slika_mat"  src="slike\mat_osm\Tabela7.png" style="width: 28%;">

			<p id="mat_sadrzaj">Zaključak na osnovu poretka:</p>

			<p id="formula">U_dole_desno_duž_3 = ( r - 2 ) * ( k - 2)   <i>(14)</i></p>

			<p id="mat_sadrzaj">
				Za <b>r,k &#8712 [3, 12]</b> , rezultat funkcije mora biti isti kao i u tablici. Iako su za svaki slučaj isti, ne može se znati unapred da je pretpostavka tačna sve dok se ne testira konačna funkcija za sve smerove.
			</p>

			<img id="slika_mat"  src="slike\mat_osm\Tabela8.png" style="width: 25%;">

			<br>
			<h3 style="border-top: 1px solid #a9b1ef; border-left: 1px solid #7e8ae7">Dole_desno putevi dužine 4   ( dole_desno_duž_4 )</h3>

			<img id="slika_mat" src="slike\mat_osm\Tabela9.png" style="width: 32%;">

			<br>
			<p id="formula">U_dole_desno_duž_4 = ( r - 3 ) * ( k - 3)   <i>(15)</i></p>

			<img id="slika_mat"  src="slike\mat_osm\Tabela10.png" style="width: 25%;">
			<br>

			<p id="mat_sadrzaj">
				Jedino se treba obratiti pažnja da putevi duži od 3 polja ne postoje u kraćim dužinama. Ne može stati reč dužine 4 slova u osm. čija je bar jedna dimenzija 3. Ista logika važi i za ostale dužine. Označeni su nulama u tabelama.
			</p>

			<p id="mat_sadrzaj">
				Izvlači se zaključak da je funkcija za sve puteve dole_desno:
			</p>

			<img id="slika_mat" src="slike\mat_osm\Tabela11.png" style="width: 47%;">
			<br>

			<p id="mat_sadrzaj">i konačno skraćenje funkcije za osm. 12*12 i veće:</p>

			<p id="formula">U_dole_desno = 10rk - 65r - 65k + 505   <i>(17)</i></p>

			<p id="mat_sadrzaj">Uzima se maksimum jer reč dužine n slova ne može stati u dijagonalni smer osm. čija je bar jedna dimenzija manja od n.</p>

			<br>
			<h3 style="border-top: 1px solid #a9b1ef; border-left: 1px solid #7e8ae7">Ukupan broj puteva (samo za r, k ≥ 12)</h3>

			<p id="mat_sadrzaj">
				Kroz programski kod se ispostavilo da je ukupan broj puteva smera <i>gore desno</i> isti kao i ukupan broj puteva smera <i>dole desno</i> samo treba da se obrnu red i kolona kao argumenti funkcijama:
			</p>

			<img id="slika_mat" src="slike\mat_osm\Tabela12.png" style="width: 47%;">
			<br>

			<p id="mat_sadrzaj">Uvrštavanjem ranije dobijenih funkcija za svih 8 smerova:</p>

			<img id="slika_mat" src="slike\mat_osm\Tabela13.png" style="width: 47%;">
			<br>

			<p id="mat_sadrzaj">Zamenom u glavnu funkciju (iz 1) dobije se:</p>

			<img id="slika_mat" src="slike\mat_osm\Tabela14.png" style="width: 47%;">
			<br>

			<img id="slika_mat" src="slike\mat_osm\Tabela15.png" style="width: 37%;">

			<br>
			<h3 style="border-top: 1px solid #a9b1ef; border-left: 1px solid #7e8ae7">Funkcija ukupnog broja puteva je kvadratna</h3>
			
			<p id="mat_sadrzaj">
				Kada se posmatraju slučajevi gde su r = k , funkcija se dodatno skraćuje i time lakše oučava da je kvadratna;<br> 
				pošto je funkcija za r, k ≥ 12:
			</p>

			<p id="formula">Ukupno = 80rk - 390r - 390k + 2020  </p>

			<p id="mat_sadrzaj">za r = k , radi preglednosti <b>x</b> = r = k :</p>

			<p id="formula">Ukupno_x = 80x<sup>2</sup> - 780x + 2020   <i>(19)</i></p>

			<p id="mat_sadrzaj">funkcija je kvadratna (<i>parabola</i>):</p>

			<img id="slika_mat" src="slike\mat_osm\Slika9.jpg" style="width: 60%;">
			<br>

			<p id="tekst_slike">Slika 9. Graf kvadratne funkcije za r = k</p>

			<br>
			<h3 style="border-top: 1px solid #a9b1ef; border-left: 1px solid #7e8ae7">Zaključak dobijen matematičkom funkcijom</h3>

			<p id="mat_sadrzaj">
				Vrednosti koeficijenata su direktan proizvod ograničenja dužine puta i broja smerova koji postoje.
				U slučaju da se traži funkcija ukupnog broja puteva za druga ograničenja dužina puta, neophodno je proći kroz navedene korake, kako bi se izračunale zavisnosti i koeficijenti. Dakle, struktura funkcije bi ostala ista, samo bi koefiijenti bili drugačiji. 
			</p>

			<p id="mat_sadrzaj">
				Najbolje bi bilo da se koeficijenti od samog početka zamene min/max funkcijama kako bi konačna funkcija mogla da izračuna ukupan broj puteva za 8 smerova bilo koje dimenzije r*k. Ova funkcija bi već mogla da se koristi za druge problematike kombinatorike i teorije grafova.
			</p>

			<p id="mat_sadrzaj">
				Za svaku r*k osm. gde su r,k ≥3, može se izvršiti izračunavanje ukupnog broja puteva na <a href="/testiranje_rada_klase_osmosmerka_templejt.php" style="color: #007acc;"><i>sledećoj stranici</i></a> i prikazati tablica prolazaka tih puteva, kroz svako polje. Pošto bi bilo neefikasno da se svaki put prikazuje kao strelica, u tablici, vrednost svakog polja se uvećava za 1 ako je deo nekog puta.
			</p>

			<br><br>
		</div>





	<div id="content-wrap">
		<footer id="footer"><small>&copy; Copyright 2021.   Dimitrije Drakulić</small></footer>
	</div>	
	
	</div>
</body>
</html>
