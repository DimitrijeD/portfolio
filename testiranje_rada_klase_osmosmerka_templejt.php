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
	<title>Темплејти осмосмерке</title>
</head>
<body>
	<div class="container">
		
		<?php
		echo napravi_heading($korisnik->podaci_k()->tip_korisnika, $korisnik->podaci_k()->id);
		?>

		<h2>Табела умрежености осмосмерке</h2>

		<form id="forma_o_i" action="" method="post">
			<div id="paralelno">
				<label for="red_velicina_osmosmerke">Унесите висину (ред) осмосмерке</label>
				<input type="text" name="red_velicina_osmosmerke" id="red_velicina_osmosmerke" autofocus="autofocus" autocomplete="off">
				<br>
			</div>
			<div id="paralelno">
				<label for="kolona_velicina_osmosmerke">Унесите ширину (колону) осмосмерке</label>
				<input type="text" name="kolona_velicina_osmosmerke" id="kolona_velicina_osmosmerke" autocomplete="off">
				<br>
			</div>
			<input type="submit" name="napravi_osmosmerku" value="Направи осмосмерку">
		</form><br>


		<!--
		---------------------------------------------------------- FALI VALIDACIJA --------------------------------------------------------------------  
		-->
		<?php
		if(isset($_POST['red_velicina_osmosmerke']) AND $_POST['kolona_velicina_osmosmerke'])
		{
			if ( ($_POST['red_velicina_osmosmerke'] >= 3  AND $_POST['kolona_velicina_osmosmerke'] >= 3 ) AND  
				 ($_POST['red_velicina_osmosmerke'] <= 60 AND $_POST['kolona_velicina_osmosmerke'] <= 60) ) 
			{

				$red = (int)$_POST['red_velicina_osmosmerke'];
				$kolona = (int)$_POST['kolona_velicina_osmosmerke'];

				$br_puteva_klasa = new Testiranje_formule_broja_puteva_u_osm($red, $kolona);
				$br_puteva_rez = $br_puteva_klasa->izracunaj_broj_puteva();

				$osmosmerka_instanca = new Osmosmerka_templejt($red, $kolona, 12, FALSE);
				$niz_svih_puteva = $osmosmerka_instanca->svi_putevi();
				$max_rec = $osmosmerka_instanca->najduza_moguca_rec();
				$max_red = $osmosmerka_instanca->vrati_red();
				$max_kolona = $osmosmerka_instanca->vrati_kolona();
					// print "<pre>";
					// print_r($niz_svih_puteva);
					// print "</pre>";
					// print_r(count($niz_svih_puteva));
				echo '<div class="dodatni_podaci">';
				echo "<h3>Формула за рачунање укупног броја путева које осмосмерка може имати</h3><br>";
				echo "<h5>Величина осмосмерке је <strong>" . $br_puteva_klasa->vrati_red() . " * " . $br_puteva_klasa->vrati_kolonu() . "</strong></h5>";
				echo "<h5>Укупан број путева добијен класом (математичком формулом) Testiranje_formule_broja_puteva_u_osm је: <strong>" . $br_puteva_rez . "</strong></h5>";
				echo "<h5>Број путева у \$niz_svih_puteva из класе Osmosmerka_templejt je: <strong>" . count($niz_svih_puteva) . "</strong></h5>";

				if($red >= 12 and $kolona >= 12)
				{
					echo "<h5>Рачунање са изведеном формулом за димензије веће од 12 <strong>: " . $br_puteva_klasa->izracunaj_sa_izvedenom_formulom() . "</strong></h5>";
				}

				if($br_puteva_rez == count($niz_svih_puteva))
				{
					echo "<h5><strong>ИМАЈУ ИСТИ БРОЈ ПУТЕВА</strong>, МОЖЕ СЕ ЗАКЉУЧИТИ ДА СУ ОБА ПРИСТУПА ИСПРАВНА</h5>";
				} else {
					echo "<h5><strong>НЕМАЈУ ИСТИ БРОЈ ПУТЕВА! НЕШТО НЕ ВАЉА :( </strong></h5>";
				}		
				echo '</div>';
				// instnaciranje "osmosmerke" cija polja su popunjena nulama
				$niz_za_simuliranje_puteva = array ();
				for ($r = 1; $r <= $max_red; $r++)
				{
					for ($k = 1; $k <= $max_kolona; $k++)
					{
						$niz_za_simuliranje_puteva[$r][$k] = 0;
					}
				}

				// Uvecavanje polja "osmosmerke" za 1 svaki put kad u $niz_svih_puteva postoji polje 
				for($put = 0; $put < count($niz_svih_puteva); $put++)
				{
					for($polje = 0; $polje < count($niz_svih_puteva[$put]); $polje++)
					{
						if(isset($niz_svih_puteva[$put][$polje]))
						{
							$niz_za_simuliranje_puteva[ $niz_svih_puteva[$put][$polje][0] ][ $niz_svih_puteva[$put][$polje][1] ]++;
						}
					}
				}

				// print_r($niz_za_simuliranje_puteva);
				echo "<br>";
				echo '<div class="dodatni_podaci">';
				echo "<h3>Табела темплејта осмосмерке </h3><br>";
				echo "<h5>Вредност сваког поља је онолика колико пута се појављује у \$niz_svih_puteva из класе Osmosmerka_templejt</h5>";
				echo "<h5>Други начин посматрања на вредност у пољима је следећи: <br> кроз неко поље (r, k) постоји толико начина (број у пољу) да се упише реч у било ком смеру (али да пролази кроз то поље) тако да су дозвољене дужине речи од 3 до 12.</h5>";
				echo "<br>";
				echo napravi_tabelu($niz_za_simuliranje_puteva);
				echo '</div><br>';
			}
		}
		?>
		
		<div id="content-wrap">
			<footer id="footer"><small>&copy; Copyright 2021.   Dimitrije Drakulić</small></footer>
		</div>
	</div>
</body>
</html>