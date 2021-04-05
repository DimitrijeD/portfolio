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
	<title>Сплајн</title>
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

		<h2> Интерполација помоћу методе квадратни сплајн </h2>
		<details>
		<summary>Како унети вредности</summary>
			<p>Сваки чвор који унесете мора имати различите вредности X или ће Вам вратити грешку!</p>
			<p>Свака вредност за интерполирање мора бити у скупу [min x-osa čvora, max x-osa čvora] .</p>
			<p>Минимални дозвољени број чворова је 4, а максимални 100.</p>
			<p>Максимални број вредности за интерполирање је 50.</p>
			<p>Није обавезно унети вредности за интерполирање.</p>

		</details>
		<details>
		<summary>Матрица</summary>
			<p>Након рачунања, приказаће се јединична матрица чији су елементи главне дијагонале јединице, а сви остали нуле.</p>
			<p>Вредности у матрици су заокружене на 0 децималних места како би се могла исписати, наравно стварне вредности су у стандардном float.</p>
			<p>Последња колона нема улогу калкулацијама, већ само служи за приказ ротирања редова како главна дијагонала не би била нула.</p>
			<p>Може доћи до грешке приликом заокруживања бројева.</p>	
		</details>
		<details>
		<summary>Функције</summary>
			<p>Први интервал сплајна је увек линеаран, док су сви остали квадратни (параболе).</p>
			<p>Функција има: број_чворова - 1</p>
		</details>
		<details>
		<summary>Пример валидног инпута</summary>
			<p>Чворови интерполације</p>
			<p>3,12 / 4,13 / 5,16 / 6,22 / 7,36 / 8,53 / 9,68 / 10,80 / 11,86 / 12,89</p>
			<p>Вредности Х осе за интерполирање</p>
			<p>3.5 / 4.5 / 5.5 / 6.5 / 7.5 / 8.5 / 9.5 / 10.5 / 11.5</p>	
		</details>
		
		

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

		
		<form id="forma_o_i" action="" method="post" > 
			<div style="background-color:#e0ebeb;">
				<p> Испишите вредности чворова у следећем формату X<sub>0</sub>,Y<sub>0</sub> / X<sub>1</sub>,Y<sub>1</sub> / X<sub>2</sub>,Y<sub>2</sub> ... X<sub>n</sub>,Y<sub>n</sub> </p>	
				<div id="paralelno">

					<label for="cvorovi">Чворови интерполације</label>
					<input type="text" id="cvorovi" name="cvorovi" autocomplete="off" autofocus="autofocus" > 				
				</div>
			</div>
			
			<br>

			<div style="background-color:#e0ebeb;">
				<p> Испишите вредности за интерполирање у следећем формату X<sub>1</sub> / X<sub>2</sub> / X<sub>3</sub> ... X<sub>n</sub> </p>
				<div id="paralelno">				
					<label for="tacke_x">Вредности Х осе за интерполирање</label>
					<input type="text" id="tacke_x" name="tacke_x" autocomplete="off"> 
				</div>
			</div>

			<br>
			<input type="submit" value="Израчунај вредности">
		</form>

		<?php
		
		/*if( !($korisnik->ima_prava('admin')) ){
			Preusmeri::na('index.php');
		}*/ 

		if (Input::postoji())
		{
			// $cvorovi = $_POST['cvorovi'];
			// $tacke_x = $_POST['tacke_x'];

			$niz_kriterijum_validacija = array(
				'cvorovi' => array(
					'obavezno' => TRUE,
					'min_broj_cvorova' => 4,
					'max_broj_cvorova' => 100 
				),
				'tacke_x'=> array(
					'obavezno' => FALSE,
					'max_za_interpoliranje' => 50
				)

			);
			$validacija = new Validacija();
			$rez_validacije = $validacija->provera_unosa($_POST, $niz_kriterijum_validacija);
			
			if($rez_validacije->validacija_uspela())
			{
				$niz_cvorovi = $validacija->vrati_pripremljen_niz_cvorova();
				$tacke_x = $validacija->vrati_niz_interpolanata();
				$sve = gaus_jordan_metoda_eliminacije_pokusaj_2($niz_cvorovi, $tacke_x);
				$matrica             = $sve[0];
				$interpolirane_tacke = $sve[1];

				// print_r($interpolirane_tacke);
				echo ( napravi_tabelu( zaokruzi_koeficijente_za_prikaz ($matrica) ) );
				echo ( napravi_tabelu( $interpolirane_tacke ) );
			} else {
				echo '<div id="greske">';
				foreach($rez_validacije->sve_greske() as $greska)
				{
					echo '<p>' . $greska, ' </p>';
				}
				echo '</div>';
			}
		}
	
		?>
		
		<div id="content-wrap">
			<footer id="footer"><small>&copy; Copyright 2021.   Dimitrije Drakulić</small></footer>
		</div>
				
	</div>

	<script>
	if ( window.history.replaceState ) 
	{
		window.history.replaceState( null, null, window.location.href );
	}
	</script>

</body>
</html>
