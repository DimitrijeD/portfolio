<?php
function reci_sa_neparnim_br_karaktera ($niz_pretrage)
{
	$niz_reci_sa_neparnim_brojem_bajtova = array();
	foreach ($niz_pretrage as $k_reci => $polja_reci) 
	{
		foreach ($polja_reci as $kljuc => $kon_vred) 
		{
			
			if($kljuc == "rec" AND (strlen($kon_vred) % 2 != 0) AND !in_array($kon_vred, $niz_reci_sa_neparnim_brojem_bajtova))
			{ 
				array_push($niz_reci_sa_neparnim_brojem_bajtova, $niz_pretrage[$k_reci]); 
			}
		}
	}
	return $niz_reci_sa_neparnim_brojem_bajtova;
}