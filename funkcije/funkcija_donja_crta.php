<?php
require_once 'osnova/inicijalizacija.php';

// funkcija za proveru da li u stringu postoji "_" karakter
function postoji_donja_crta($string)
{
	for ($i = 0; $i < mb_strlen($string, 'Windows-1251'); $i++)
	{
		// $this->rec_razbijena_na_slova[$k] = $this->rec_za_unos_u_osmosmerku[$i] . $this->rec_za_unos_u_osmosmerku[++$i];
		if($string[$i] == '_'){
			return TRUE;
		}
	}
}
// print_r(postoji_donja_crta("абц_"));