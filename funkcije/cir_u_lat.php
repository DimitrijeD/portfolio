<?php


function cir_u_lat($str)
{
	$sol = '';

	for($i = 0; $i < strlen($str); $i++)
	{
		$da_li_je_ovo_cir_slovo = $str[$i].$str[$i+1];

		if(  isset( $GLOBALS['cir_u_lat_mala_slova'][$da_li_je_ovo_cir_slovo] )   )
		{
			$sol .= $GLOBALS['cir_u_lat_mala_slova'][$da_li_je_ovo_cir_slovo];
			$i++;
		}
		elseif (isset( $GLOBALS['cir_u_lat_velika_slova'][$da_li_je_ovo_cir_slovo] )) 
		{
			$sol .= $GLOBALS['cir_u_lat_velika_slova'][$da_li_je_ovo_cir_slovo];
			$i++;
		}		 

		else {
			$sol .= $str[$i];
		}
		
	}
	return $sol;
}

// $str = 'неки Ћирилични СтриНг, који пА, има. од-свЕга111....по мало шђжљчћ';
// var_dump(cir_u_lat($str));
?>
