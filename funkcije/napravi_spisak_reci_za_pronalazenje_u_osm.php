<?php

/*
funkcija prima niz, i treba da napravi spisak reci tako da je svaka rec u zasebnom elementu za zasebnim id-jem kako bih "posivio" (ili sta god radio) boju i time prikazao da je rec pronadjena u osmosmerci

array (size=3)
  0 => 
    array (size=6)
      'id' => string '27' (length=2)
      'rec' => string 'шах' (length=6)
      'brojac_uspesnih_unosa' => string '40' (length=2)
      'brojac_neuspesnih_unosa' => string '0' (length=1)
      'datum_unosa' => string '2020-12-17 12:38:51' (length=19)
      'tip_unosa' => null
  1 =>  . . .. . . 

*/

function napravi_spisak_reci_za_pronalazenje_u_osm($niz_svih_reci)
{
	// var_dump($niz_svih_reci[0]);
	$html = '<ul id="reci_sa_spiska">';
	// var_dump($niz_svih_reci);
	for($i = 0; $i < count($niz_svih_reci); $i++)
	{
		$id = $niz_svih_reci[$i][0] . "rec_sa_spiska";
		$html .= '<li id="' . $id . '" >' . $niz_svih_reci[$i][0] . '</li>'; //class="rec_sa_spiska"
		
	}
	$html .= '</ul>'; 
	return $html;
}

?>