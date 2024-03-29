<?php
require_once 'osnova/inicijalizacija.php';
$korisnik = new Korisnik();

if (!$korisnik->je_ulogovan_k()) 
{
	Preusmeri::na('registracija.php');
}
if(!($korisnik->ima_prava('admin')) ){
	Preusmeri::na('index.php');
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

		<?php
		echo napravi_heading($korisnik->podaci_k()->tip_korisnika, $korisnik->podaci_k()->id);
		?>
		
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


