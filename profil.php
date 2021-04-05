<?php
require_once 'osnova/inicijalizacija.php';
if(!$id = Input::vrati('korisnik')){
	Preusmeri::na('pocetna_stranica.php');
} else {
	$korisnik = new Korisnik($id);
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
	<title>Ваш профил</title>
</head>
	<body>
		<div class="container">
			<ul id="stranice">
				<li><a href="pocetna_stranica.php">Почетна страница</a></li>
				<li><a href="igraOsmosmerka.php"> Осмосмерка</a></li>
				<li><a href="kvadratna_spl.php"> Интерполација</a></li>
				<li><a href="asimetricna_osmosmerka.php">Асиметрична осмосмерка</a></li>
				<div class="dropdown">
					<div class="dropbtn">Korisnik</div>
						<div class="dropdown-content">						
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
			<h2> Ваш профил </h2>

			<?php
			
			if(!$korisnik->postoji_k())
			{
				Preusmeri::na(404);
			} else {
				$data = $korisnik->podaci_k();
				// print_r($data);
			}
			?>

			<p>Име корисника: <?php echo ocisti($data->korisnicko_ime); ?></p>
			<p>Ваша имејл адреса: <?php echo $data->email; ?></p>
			
			<div id="content-wrap">
				<footer id="footer"><small>&copy; Copyright 2021.   Dimitrije Drakulić</small></footer>
			</div>
		
		</div>
</body>
</html>
