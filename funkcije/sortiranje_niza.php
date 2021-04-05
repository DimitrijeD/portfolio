<?php

//$niz - rezultat pretrage, niz koji treba da se sortira
//$uslov - kljuc asocijativnog niza na osnovu cije vrednosti se soritra niz po rastucem poretku
//	glavna svrha je da sortira q baze da se vrati najredje koriscena rec
//ako se treci parametar postavi u poiv funkcije vraca se samo prvi niz sa najmanjom vrednoscu unosa u osmosmerke
//brojac_uspesnih_unosa

// UPDATED: sada sortira po kvalitetu
function sortiranje_niza($niz = array(), $uslov, $samo_jednu_rec = FALSE)
{
	// print_r($niz);
	if($niz == NULL)
	{
		return array(); // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	}
	// $niz = json_decode(json_encode($niz), true);
	// print_r($niz);
	$niz_vrednosti_samo_uslova = array();

	foreach ($niz as $kljuc => $vrednost) {
		$niz_vrednosti_samo_uslova[] = $vrednost[$uslov];
	}

	// print_r($niz_vrednosti_samo_uslova);
	asort($niz_vrednosti_samo_uslova);
	// echo "</br>";
	// print_r($niz_vrednosti_samo_uslova);
	foreach ($niz_vrednosti_samo_uslova as $kljuc => $vrednost) {
		$konacni_niz[] = $niz[$kljuc];
	}

	if($samo_jednu_rec){
		return $konacni_niz[0];
	} else {
		return $konacni_niz;
	}
}
// $a = array (array('id'=>1, 'rec'=>"voz"), array('id'=>3, 'rec'=>"vozilo"));
// print_r(sortiranje_niza($a, 'rec', TRUE));
