<?php

//asm_uklanjanje_polja.php
/*
Funkcija primi normalan $niz_svih_puteva , i polja asimetricne osmosmerke koja treba da se uklone iz niza_svih_puteva
Ne uklanjaju se samo ta polja, vec ceo put se uklanja iz niza, tako da kada se popunjava osmosmerka, nikad ne naidje na ta uklonjena polja
*/
function asm_uklanjanje_polja_iz_NSP($niz_svih_puteva, $asim_polja)
{
	for($a_p = 0; $a_p < count($asim_polja); $a_p++)
	{
		for($put = 0; $put<count($niz_svih_puteva); $put++)
		{
			for($polje = 0; $polje < count($niz_svih_puteva[$put]); $polje++)
			{
				if($asim_polja[$a_p] === $niz_svih_puteva[$put][$polje])
				{
					// $niz_svih_puteva[$put] = array();
					unset($niz_svih_puteva[$put]); 
					$niz_svih_puteva = array_values($niz_svih_puteva); 
					break;
				}
			}
		}
	}
	return $niz_svih_puteva;
}

/*
jedina razlika izmedju ove dve funkcije je ta sto gornja prima niz_svih_puteva sa strukturom array([put][polje][r] )
                                                                                                  (            [k] )
dok donja prima niz polja : array(polje1, polje2...), polje = array(red, kolona)
*/
function asm_uklanjanje_polja_iz_preostalih_polja($niz_preostalih_polja, $asim_polja)
{
	for($a_p = 0; $a_p < count($asim_polja); $a_p++)
	{
		for($polje = 0; $polje < count($niz_preostalih_polja); $polje++)
		{
			if($asim_polja[$a_p] === $niz_preostalih_polja[$polje])
			{
				unset($niz_preostalih_polja[$polje]); 
				$niz_preostalih_polja = array_values($niz_preostalih_polja); 
				break;
			}
		}	
	}
	return $niz_preostalih_polja;
}

function ciscenje_donje_crte_iz_asm($osmosmerka_niz, $asim_polja)
{
	for($a_p = 0; $a_p < count($asim_polja); $a_p++)
	{
		$r = $asim_polja[$a_p][0];
		$k = $asim_polja[$a_p][1];
		$osmosmerka_niz[$r][$k] = '';
	}
	return $osmosmerka_niz;
}

/*$asim_polja = array(array(1,1)	);

$niz_svih_puteva = array(
	array(array(1,1), array(2,2), array(3,3)),
	array(array(1,3), array(2,3), array(3,3)),
	array(array(3,2), array(2,2), array(1,2))
);

var_dump(asm_uklanjanje_polja($niz_svih_puteva, $asim_polja));*/

// $niz_preostalih_polja = array(array(1,2));
// $asim_polja = array(array(2,1));

// var_dump(asm_uklanjanje_polja_iz_preostalih_polja($niz_preostalih_polja, $asim_polja));

?>