<?php

// sluzi za grupisanje svih nizova pisama cirilice i latinice radi preglednosti koda 


// koristi se u klasi Osmosmerka u metodi kvaliteta
$GLOBALS['suglasnici'] = array("Б", "В", "Г", "Д", "Ђ", "Ж", "З", "Ј", "К", "Л", "Љ", "М", "Н", "Њ", "П", "С", "Т", "Ћ", "Ф", "Х", "Ц", "Ч", "Џ", "Ш");

// R je medju samoglasnicima jer postoje reci od vise slova u kojima nema samoglasnika npr krst, trst , ima ih dosta
// ovaj se ne koristi vise u osmosmerci
// $GLOBALS['samoglasnici'] = array ("А", "Е", "И", "О", "У", "Р");



// 
$GLOBALS['niz_slova_abecede'] = array("z", "x", "c", "v", "b", "n", "m", "a", "s", "d", "f", "g", "h", "j", "k", "l", "q", "w", "e",  "r", "t", "y", "u", "i", "o", "p", "ć", "š", "đ", "ž", "č",
							   "Z", "X", "C", "V", "B", "N", "M", "A", "S", "D", "F", "G", "H", "J", "K", "L", "Q", "W", "E", 
	    "R", "T", "Y", "U", "I", "O", "P", "Ć", "Š", "Đ", "Ž", "Č");


// REFAKTURISATI onu besmislenu stranicu za latinicna slova da koristi ove nizove ispod umestno 'niz_slova_abecede' jer taj niz nema smisla, u njemu su i americka slova w,q.. i srpska latinična što nema smisla xd
$GLOBALS['lat_slova_mala'] = array("a", "b", "c", "č", "ć", "d", "dž", "đ", "e", "f", "g", "h", "i", "j", "k", "l", "lj", "m", "n", "nj", "o", "p", "r", "s", "š", "t", "u", "v", "z", "ž");

$GLOBALS['cir_slova_mala'] = array("а", "б", "в", "г", "д", "ђ", "е", "ж", "з", "и", "ј", "к", "л", "љ", "м","н", "њ", "о", "п", "р", "с", "т", "ћ", "у", "ф", "х", "ц", "ч", "џ", "ш");

$GLOBALS['lat_slova_velika'] = array("A", "B", "C", "Č", "Ć", "D", "Dž", "Đ", "E", "F", "G", "H", "I", "J", "K", "L", "Lj", "M", "N", "Nj", "O", "P", "R", "S", "Š", "T", "U", "V", "Z", "Ž");

$GLOBALS['cir_slova_velika'] = array("А", "Е", "И", "О", "У", "Р", "Б", "Б", "Г", "Д", "Ђ", "Ж", "З", "Ј", "К", "Л", "Љ", "М", "Н", "Њ", "П", "С", "Т", "Ћ", "Ф", "Х", "Ц", "Ч", "Џ", "Ш");

$GLOBALS['dvobajtni_latinicni_karakteri'] = array("č", "ć", "đ", "š", "ž", "Č", "Ć", "Đ", "Š", "Ž");

$GLOBALS['brojevi_sa_tackom_zarezom'] = array('.', ',' , '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ' ', '-');

// hash table za cirilicu
$GLOBALS['hash_t_cirilica'] = array(
	"а" => "A", 
	"б" => "Б", 
	"в" => "Б", 
	"г" => "Г", 
	"д" => "Д", 
	"ђ" => "Ђ", 
	"е" => "Е", 
	"ж" => "Ж", 
	"з" => "З", 
	"и" => "И", 
	"ј" => "Ј", 
	"к" => "К", 
	"л" => "Л", 
	"љ" => "Љ", 
	"м" => "М",
	"н" => "Н", 
	"њ" => "Њ", 
	"о" => "О", 
	"п" => "П", 
	"р" => "Р", 
	"с" => "С", 
	"т" => "Т", 
	"ћ" => "Ћ", 
	"у" => "У", 
	"ф" => "Ф", 
	"х" => "Х", 
	"ц" => "Ц", 
	"ч" => "Ч", 
	"џ" => "Џ", 
	"ш" => "Ш"
);
// -----------------------------------------------------------------------------------------------------------------------------------------------------

?>