<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="./css/stil.css">
	</head>
<body>
	<div class="container">
		<?php
		require_once 'osnova/inicijalizacija.php';
		$korisnik = new Korisnik();
		if(!($korisnik->ima_prava('admin')) ){
			Preusmeri::na('pocetna_stranica.php');
		} 
		?>

		<ul>
			<li><a href="pocetna_stranica.php"> Почетна страница </a></li>
			<li><a href="igraOsmosmerka.php"> Игра осмосмерка </a></li>
			<li><a href="admin_stranica.php"> Унос речи у осмосмерку </a></li>

			<li><a href="odjava.php"> Одјава </a></li>
		</ul><br>
		<ul>
			<li><a href="brisanje_reci_sa_neparnim_brojem_karaktera.php"> Брисање свих речи са непарним бројем карактера </a></li>
		</ul>

		<?php
		$bp_instanca = Baza_podataka::vrati_instancu();
		$bp_instanca->pronadji('reci_osmosmerke', array('rec', 'LIKE', '%')); // mora trenutno ovako jer metoda priprema ocekuje array i poziva upit samo ako ima 3 elementa u nizu 
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

		//mogao sam jednostavno da poredim svaki karakter sa heksadecimalnim vrednostima cirilicnih karaktera..... kako god.. posle
		?>
	</div>
</body>
</html>


