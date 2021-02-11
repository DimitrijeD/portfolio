<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../css/stil.css">
</head>
<body>
	<div class="container">

<?php
// require_once '../osnova/inicijalizacija.php';
require_once '../klase/Osmosmerka_templejt.php';
require_once '../funkcije/funckija_napravi_tabelu.php';

/*
**************************************************Skripta za testiranje rada klase Osmosmerka_templejt.***********************************
Nizovi $niz_osmosmerka i $niz_za_simuliranje_puteva su jednaki po dimenzijama.
Takodje jedno polje osmosmerke predstavlja isto polje $niz_za_simuliranje_puteva.
Funkcija napravi_tabelu() ispisuje tabelu cije vrednosti polja predstavljaju broj reci koje mogu da prodju kroz to polje;
	drugim recima, koliko puta je neko polje u $niz_svih_puteva, tolika je vrednost polja u tabeli.
		Niz dobijen metodom svi_putevi() je: niz => put => polje ($r,$k) tako da svako polje ovog niza, uvecava vrednost polja $niz_za_simuliranje_puteva[$r[$k]. 
*/

// PROMENITE PRVA DVA ARGUMENTA KONSTRUKTORU  (red, kolona, ...) I REFRESH STRANICU 
// http://localhost/SI2_Dimitrije_Drakulic/skripte_za_testiranje/testiranje_rada_klase_osmosmerka_templejt.php
?>
	<ul>
		<li><a href="../pocetna_stranica.php"> Почетна страница </a></li>
		<li><a href="../admin_stranica.php"> Админ страница са алатима </a></li>
	</ul> <br><br>
	<p1>Приказ свих могућих путева која "r*k" осмосмерка може да има, тако што свако поље приказане таблице је једнако броју појављивања тог поља у $niz_svih_puteva .</p1> <br><br><br>
	<form action="" method="post">
		<label for="red_velicina_osmosmerke">Унесите висину (ред) осмосмерке</label>
		<input type="text" name="red_velicina_osmosmerke" id="red_velicina_osmosmerke" autofocus="autofocus" autocomplete="off">
		<br>

		<label for="kolona_velicina_osmosmerke">Унесите ширину (колону) осмосмерке</label>
		<input type="text" name="kolona_velicina_osmosmerke" id="kolona_velicina_osmosmerke" autocomplete="off">
		<br>
		<input type="submit" name="napravi_osmosmerku" value="Направи осмосмерку">
	</form>
<?php
if(isset($_POST['red_velicina_osmosmerke']) AND $_POST['kolona_velicina_osmosmerke'])
{
	if ($_POST['red_velicina_osmosmerke'] >= 3 AND $_POST['kolona_velicina_osmosmerke'] >= 3)  
	{
		$red = $_POST['red_velicina_osmosmerke'];
		$kolona = $_POST['kolona_velicina_osmosmerke'];
		$osmosmerka_instanca = new Osmosmerka_templejt($red, $kolona, array(), array(), 12);
		$niz_svih_puteva = $osmosmerka_instanca->svi_putevi();
		$max_rec = $osmosmerka_instanca->najduza_moguca_rec();
		$max_red = $osmosmerka_instanca->vrati_red();
		$max_kolona = $osmosmerka_instanca->vrati_kolona();
			// print "<pre>";
			// print_r($niz_svih_puteva);
			// print "</pre>";
			// print_r(count($niz_svih_puteva));

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

		echo napravi_tabelu($niz_za_simuliranje_puteva);
	}
}
?>
</div>
</body>
</html>