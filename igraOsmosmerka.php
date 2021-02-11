<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
</head>
<body>
<?php
require_once 'osnova/inicijalizacija.php';
$korisnik = new Korisnik();

	if ( !($korisnik->je_ulogovan_k()) ) {	
		Preusmeri::na('registracija.php'); 
	} 

	
?>
<div class="container">
	<ul>
		<?php if ($korisnik->ima_prava('admin')) {	
	 ?> <li><a href="admin_stranica.php"> Админ страница са алатима </a></li> <?php } ?>
		<li><a href="pocetna_stranica.php"> Почетна страница </a></li>
		<li><a href="odjava.php"> Одјава </a></li>
	</ul>

	<p>Напомена: најмања осмосмерка која може да се формира је величине 3*3. Ако се унесу превелике вредности осмосмерке формираће се полупразна осмосмерка и потрајаће пар секунди.</p>
	<form action="" method="post">
		<label for="red_velicina_osmosmerke">Унесите висину (ред) осмосмерке</label>
		<input type="text" name="red_velicina_osmosmerke" id="red_velicina_osmosmerke" autofocus="autofocus" autocomplete="off">
		<br>

		<label for="kolona_velicina_osmosmerke">Унесите ширину (колону) осмосмерке</label>
		<input type="text" name="kolona_velicina_osmosmerke" id="kolona_velicina_osmosmerke" autocomplete="off">
		<br><br>

		<label for="reci_od_korisnika">Унесите речи које желите да буду у осмосмерци (опционално)</label><br>
		<label for="reci_od_korisnika">Сваку реч одвојите зарезом</label>
		<input type="text" name="reci_od_korisnika" id="reci_od_korisnika" autocomplete="off">
		<br>
		<input type="submit" name="napravi_osmosmerku" value="Направи осмосмерку">
	</form>

	<?php

	if (Input::vrati('napravi_osmosmerku')) //Input::postoji() AND 
	{
		// var_dump(Input::vrati('reci_od_korisnika'));
		// print_r(Input::vrati('resenje'));
		$niz_kriterijum_validacija = array(
			'red_velicina_osmosmerke' => array(
				'obavezno' => TRUE,
				'velicina_osmosmerke' => 3
				//'max' => 40,  trenutno ne znam koliko browz mose da podnese, testirati kasnije
			),
			'kolona_velicina_osmosmerke' => array(
				'obavezno' => TRUE,
				'velicina_osmosmerke' => 3
				//'max' => 40,  trenutno ne znam koliko browz mose da podnese, testirati kasnije
			),				
		);
		
		$reci_od_korisnika = explode(",", Input::vrati('reci_od_korisnika'));

		$validacija = new Validacija();
		$rez_validacije = $validacija->provera_unosa($_POST, $niz_kriterijum_validacija);

		if($rez_validacije->validacija_uspela())
		{
			// kastovanje promenljivih na int
			$red = (int)Input::vrati('red_velicina_osmosmerke');
			$kolona = (int)Input::vrati('kolona_velicina_osmosmerke');
			?>
			<p>Решите осмосмерку. Ако преостану нека не прецртана слова (након прецртавања свих слова), од њих склопите реч и унесите решење овде: </p>
			
			<?php
			$osmosmerka = new Osmosmerka($red, $kolona, $reci_od_korisnika, $korisnik->podaci_k()->id);
			echo napravi_tabelu($osmosmerka->popunjavanje_sa_korisnickim_recima()); 	
			$korisnik->napravio_osmosmerku();	

			/*
			rekurzija po obicaju ne pomaze u ovom problemu
			do{
				$osmosmerka = new Osmosmerka($red, $kolona, array(), array(), "", "", $korisnik->podaci_k()->id);
				$osmosmerka->popunjavanje_osmosmerke();
			} while ($osmosmerka->da_li_je_osm_popunjena() == FALSE);

			echo napravi_tabelu($osmosmerka->osmosmerka_niz );

			$korisnik->napravio_osmosmerku();
			*/	
				
			} else {
			foreach($rez_validacije->sve_greske() as $greska){
				echo "$greska, '<br>";
			}
		}
	}
	
	?>
</div>
<script>
	if ( window.history.replaceState ) {
  		window.history.replaceState( null, null, window.location.href );
	}
</script>
</body>
</html>

