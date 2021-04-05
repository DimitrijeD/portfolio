<?php

function obradi_asim_polja($_a_polja)
{
	$rez = array();
	foreach ($_a_polja as $key => $value) 
	{
		$polje = explode("/", $_a_polja[$key]);
		$polje[0] = (int)$polje[0];
		$polje[1] = (int)$polje[1];
		$rez[] = $polje;
	}
	return $rez;
}

?>