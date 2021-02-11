<?php
function reci_sa_latinicnim_slovom($niz_pretrage)
{

	$niz_slova_abecede = array("z", "x", "c", "v", "b", "n", "m", "a", "s", "d", "f", "g", "h", "j", "k", "l", "q", "w", "e",  "r", "t", "y", "u", "i", "o", "p", "ć", "š", "đ", "ž", "č",
							   "Z", "X", "C", "V", "B", "N", "M", "A", "S", "D", "F", "G", "H", "J", "K", "L", "Q", "W", "E", 
	    "R", "T", "Y", "U", "I", "O", "P", "Ć", "Š", "Đ", "Ž", "Č");

	$niz_latinicnih_reci = array();
	$rez = array();
	foreach ($niz_slova_abecede as $kljuc_abc => $slovo_abc) 
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