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
		</ul>	

		<br>
		<p>Валидација следеће форме тренутно не постоји! Унети податке по упутству.</p>
		<p>Сваки чвор који унесете мора имати различите вредности X или ће Вам вратити грешку!</p>
		<!-- 
		<p>0,0 / 10,227.04 / 15,362.78 / 20,517.35 / 22.5,602.97 / 30,901.67</p>
		<p>9 / 15 / 21 / 25</p>
		 -->
		<!-- 
		<p>3,12 / 4,13 / 5,16 / 6,22 / 7,36 / 8,53 / 9,68 / 10,80 / 11,86 / 12,89</p>
		<p>3.5 / 4.5 / 5.5 / 6.5 / 7.5 / 8.5 / 9.5 / 10.5 / 11.5 </p>
		 -->

		<!-- 		 
		<p>2,12 / 3,12 / 6,22 / 9,68 / 12,89 / 13,89</p>
		 <p>4 / 5 / 7 / 8 / 10 / 11</p> 
		-->

		<br>

		<h2> Интерполација помоћу методе квадратни сплајн </h2>
		<form action="" method="post" > 
			<div>
				<p> Испишите вредности чворова у следећем формату X0,Y0 / X1,Y1 / X2,Y2 ... Xn,Yn </p>
				<label for="cvorovi">Чворови интерполације</label>
				<input type="text" id="cvorovi" name="cvorovi" autocomplete="off" autofocus="autofocus" > 
				<br><br>

				<p> Испишите вредности за интерполирање у следећем формату X1 / X2 / X3 ... Xn </p>
				<label for="tacke_x">Вредности Х осе за интерполирање</label>
				<input type="text" id="tacke_x" name="tacke_x" autocomplete="off"> 
			</div>
			<br>
			<input type="submit" value="Израчунај вредности">
		</form>

		<?php
		require_once 'osnova/inicijalizacija.php';
		$korisnik = new Korisnik();
		
		if( !($korisnik->ima_prava('admin')) ){
			Preusmeri::na('pocetna_stranica.php');
		} 

		if (Input::postoji())
		{
			$cvorovi = $_POST['cvorovi'];
			$tacke_x = $_POST['tacke_x'];

			$sve = gaus_jordan_metoda_eliminacije_pokusaj_2($cvorovi, $tacke_x);
			$matrica             = $sve[0];
			$interpolirane_tacke = $sve[1];

			// print_r($interpolirane_tacke);
			echo ( napravi_tabelu( zaokruzi_koeficijente_za_prikaz ($matrica) ) );
			echo ( napravi_tabelu( $interpolirane_tacke ) );
		}
	
		?>
		
	</div>

	<script>
	if ( window.history.replaceState ) 
	{
		window.history.replaceState( null, null, window.location.href );
	}
	</script>

</body>
</html>
