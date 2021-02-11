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
			<li><a href="odjava.php">Одјава</a></li>
		</ul><br>
		<p1>Алати за одржавање валидности карактера у речима од којих се формирају осмосмерке</p1>
		<ul>
			<li><a href="tabela_svih_reci_za_osmosmerke.php">Приказ свих речи од којих се праве осмосмерке</a></li> 
			<li><a href="brisanje_reci_sa_neparnim_brojem_karaktera.php"> Брисање свих речи са непарним бројем карактера </a></li>
			<li><a href="brisanje_reci_sa_latinicnim_karakterom.php"> Брисање свих речи са латиничним карактером </a></li>
		</ul>
		<p1>Други алати</p1>
		<ul>
			<li><a href="skripte_za_testiranje/testiranje_rada_klase_osmosmerka_templejt.php"> Алат за тестирање рада класе Osmosmerka_tempejt </a></li>
			<li><a href="glomazni_unos_reci.php"> Алат за масовни/гломазни/bulk унос речи у табелу за попуњавање осмосмерки </a></li>
			<li><a href="kvadratna_spl.php"> Интерполација квадратурном формулом </a></li>
			
		</ul>	

		<!-- 
		You can use pattern attribute of HTML5 to allow only letters in a text field, like this:
		<input type="text" name="fieldname1" pattern="[a-zA-Z]{1,}" required>      .......kasnije
		 svih ostalih karaktera. Kad naiđe na njih, treba da prepozna da je tu kraj te reči i da je stavi u niz koji predstavlja skupljene reči iz ovog stringa.
		 -->

		<?php
		require_once 'osnova/inicijalizacija.php';
		$korisnik = new Korisnik();
		
		if( !($korisnik->ima_prava('admin')) ){
			Preusmeri::na('pocetna_stranica.php');
		} 

		if (Input::postoji())
		{
			$niz_kriterijum_validacija = array(
					'rec' => array(
						'obavezno' => TRUE,
						'min' => 6,
						'max' => 24, // jer su sva cirilicna slova 2 bajta
						'jedinstven' => 'reci_osmosmerke'
					)
				);
			$validacija = new Validacija();
			$rez_validacije = $validacija->provera_unosa($_POST, $niz_kriterijum_validacija);
			// var_dump($_POST);
			if($rez_validacije->validacija_uspela())
			{
				$bp_instanca = Baza_podataka::vrati_instancu();
				
				$broj_slova_u_reci = mb_strlen($_POST['rec']);
				$tabela = "reci_osmosmerke_"."{$broj_slova_u_reci}";

				$bp_instanca->unesi($tabela, $_POST); 
				echo "Успешна валидација, реч је унета у табелу - {$tabela}" . "<br>";
				print_r(Input::vrati('rec'));

			} else {
				foreach($rez_validacije->sve_greske() as $greska){
					echo "$greska, '<br>";
				}
			}
		}
	// --------------------------------------- Unos reci u tabelu za osmosmerku -------------------------------------------
		?>
		
		<h2> Унос речи у табелу за осмосмерку (reci_osmosmerke) </h2>
		<form action="" method="post" > <!-- accept-charset="Windows-1251" -->
			<div>
				<label for="rec">Унесите ћириличну реч</label>
				<input type="text" id="rec" name="rec" autocomplete="off" autofocus="autofocus" > <!-- pattern="[а-Za-z]{3,12}"  -->
			</div>
			<input type="submit" value="Унеси реч">
		</form>

		<!-- <h2>Направи корисника/администратора</h2> -->
	</div>
	<script>
		if ( window.history.replaceState ) {
  		window.history.replaceState( null, null, window.location.href );
	}
</script>
</body>
</html>
