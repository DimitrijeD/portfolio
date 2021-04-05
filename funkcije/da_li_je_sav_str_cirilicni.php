<?php

// vraca true ako je svaki karakter u stringu neki od slova srpske cirilice
// u suprotnom false

function da_li_je_sav_str_cirilicni($string)
{
	if (!is_string($string)) 
	{
		return false;
	}

	$duzina_str = strlen($string);
	
	// mora biti paran broj bajtova u cirilicnom stringu
	$а = $duzina_str % 2;
	if($а % 2 !== 0)
	{
        return false;
    }

	// loopuje za svaki drugi bajt string
	
	for ($i=0; $i < $duzina_str; $i=$i+2) 
	{ 
		if (isset($string[$i+1])) 
		{
			// ako bajt i njegov susedni (koji formiraju slovo stringa) nisu u bar jednom od dva niza, vrati false
			if ( !( in_array($string[$i].$string[$i+1], $GLOBALS['cir_slova_mala'])
				 OR in_array($string[$i].$string[$i+1], $GLOBALS['cir_slova_velika']) ) )
			{
				return false;
			}
		}
	}

	// da, string je potpuno cirilicni
	return true;
}

?>