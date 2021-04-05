<?php
require_once 'osnova/inicijalizacija.php';
$korisnik = new Korisnik();

if (!$korisnik->je_ulogovan_k()) 
{
	Preusmeri::na('registracija.php');
}
if(!($korisnik->ima_prava('admin')) ){
	Preusmeri::na('pocetna_stranica.php');
} 
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="./css/stil.css">
		<title>Чишћење базе</title>
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
		<h2> Брисање свих речи са латиничним карактером </h2>

		<?php
		$bp_instanca = Baza_podataka::vrati_instancu();
		$bp_instanca->pronadji('reci_osmosmerke', array('rec', 'LIKE', '%')); 
		$niz_pretrage = $bp_instanca->rezultati_bp();
		$niz_pretrage = json_decode(json_encode($niz_pretrage), true);
		// print_r($niz_pretrage); - sve reci u nizu

		echo "<p>Листа свих речи које имају у себи латинични карактер</p>";
			$sa_lat_slovom = reci_sa_latinicnim_slovom($niz_pretrage);

			if (Input::postoji()) 
			{
				foreach ($sa_lat_slovom as $br_reci=>$niz_polja_reci)
				{
					// print_r($niz_polja_reci);
					$rec = array('rec'=>$niz_polja_reci);
					$bp_instanca->obrisi('reci_osmosmerke', array('rec', '=', $rec['rec']));
				}
				Preusmeri::na('brisanje_reci_sa_latinicnim_karakterom.php'); // refresh stranice
			}
			if($sa_lat_slovom)
			{
				echo("<table>");	 
				$i = 1;
				foreach ($sa_lat_slovom as $lat_rec) 
				{
					echo('<tr>'); 
						echo('<td>'); 
							echo $i . ".  "; 
							print_r($lat_rec);  
						echo('</td>');
						$i++;
					echo('</tr>'); 
				}
				echo('</table>');
				echo('<form action="" method="post">');
					echo('<input type="submit" name="obrisi_sve_lat_reci" value="Обришите све речи са латиничним карактером">');
				echo ('</form>');
			} else {
				echo "<p1>У табели -reci_osmosmerke- нема речи које имају латинични карактер у себи!</p>";
			}
		echo "<br>" . "<p1>Ако је листа празна, онда је табела попуњена само ћириличним словима али и даље није урађен код за проверу осталих карактера као што су:  ; ' ! # ...  </p1>";
		?>

		<div id="content-wrap">
			<footer id="footer"><small>&copy; Copyright 2021.   Dimitrije Drakulić</small></footer>
		</div>	
		
	</div>
</body>
</html>


