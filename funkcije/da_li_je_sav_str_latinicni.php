<?php

// vraca true ako je svaki karakter u stringu neki od slova srpske latinice
// u suprotnom false

function da_li_je_sav_str_latinicni($string)
{
	if (!is_string($string)) 
	{
		return false;
	}
	$duzina_string = strlen($string);

	for ($i=0; $i < $duzina_string; $i++) 
	{ 
		// mora ova provera kako ne bi bio notice za poslednji kljuc stringa
		// ako su posmatrani bajt niza i njegov sledeci postoje, i ako zajedno formiraju dvobajtni lat karakter, pre inkrementuj brojac 
		// jer taj susedni bajt predstavlja drugu polovinu dvobajtnog karaktera i nikad nece biti tacan
		if( isset($string[$i + 1]) AND in_array( $string[$i].$string[$i+1], $GLOBALS['dvobajtni_latinicni_karakteri']) )  
		{
			++$i;
		} elseif( in_array($string[$i], $GLOBALS['lat_slova_mala']) OR in_array($string[$i], $GLOBALS['lat_slova_velika']) )
		{
			// ne radi nista osim sto nece uci u else ako je elseif true.. strasno
		} else {
			// bajt stringa nije ni u jednom od gore navedenih nizova, sto znaci da taj karakter nije nijedno slovo srpske latinice
			return false;
		}			
	}

	// da, string je potpuno latinicni
	return true;	
		
}

?>