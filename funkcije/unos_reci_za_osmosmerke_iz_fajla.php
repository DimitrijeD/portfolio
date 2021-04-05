<?php

/*

return type: array (
	0=>array('rec'=>"ћирилична")
	0=>array('rec'=>"реченица")
)

u ovom formatu je kako bi se pripremio unos svih reci u bazu jer su kolone tabla (3-12) pod nazivom "rec", ostale kolone tabele su default (brojaci, datum, itd.)

*/

function unos_reci_za_osmosmerke_iz_fajla($string)
{
	$string = mb_strtolower(lat_u_cir(trim($string)));
	$niz_svih_reci = array();
	$niz_svih_reci = explode("/", $string);

	$temp = array();

	// niz svih reci koje 
	$niz_svih_reci_rez = array();

	// uklanjanje praznih elemenata niza
	for($i = 0; $i < count($niz_svih_reci); $i++)
	{
		// uklanja reci krace od 5 slova i elemente niza koji su prazni
		if( !($niz_svih_reci[$i] == NULL OR mb_strlen($niz_svih_reci[$i]) < 5) )
		{
			$temp['rec'] = $niz_svih_reci[$i];
			array_push($niz_svih_reci_rez, $temp);
		}
	}

	// var_dump($niz_svih_reci_rez);
	// exit();
	return $niz_svih_reci_rez;	
}

?>