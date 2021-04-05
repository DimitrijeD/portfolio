<?php
function reci_sa_latinicnim_slovom($niz_pretrage)
{
	$niz_latinicnih_reci = array();
	$rez = array();
	foreach ($GLOBALS['niz_slova_abecede'] as $kljuc_abc => $slovo_abc) 
	{
		foreach ($niz_pretrage as $key => $value) 
		{
			foreach ($value as $kljuc => $kon_vred) 
			{
				
				if($kljuc == "rec")
				{
					// var_dump($kon_vred);
					if(rec_ima_karakter_u_sebi($kon_vred, $slovo_abc) AND !in_array($kon_vred, $niz_latinicnih_reci)) 
					{ 
						array_push($niz_latinicnih_reci, $kon_vred);
						
					}
				}
			}
		}
	}
	return $niz_latinicnih_reci;
}