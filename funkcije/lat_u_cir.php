<?php

/*
Sve sto funkcija radi jeste, primi latinicni string i konvertuje ga u cirilicni tako da karakter koji ne preponza, prepise u cirilicni string.

Nepotrebno sam koristio swithc umesto da sam napravio asoc niz gde su kljucevi latinicna slova a vrednosti cirilicna slova... napravljeno ispod u komentaru

return type string
svaka rec je odvojena "/" 
primer:
	Нека/ћирилична/реченица/конвертована/из/латинице

ne menjaju se velika i mala slova
ako je tacka na kraju, ostavice delimiter "/"" a nece staviti tacku iz nekog razloga, mrzi me da debag
*/

function lat_u_cir($string){
	$duzina_stringa = strlen($string);
	$kon_string = '';


	for($i = 0; $i < $duzina_stringa; $i++)
	{
		if(isset($string[$i+1]) AND (( $string[$i].$string[$i+1] == "dž" OR $string[$i].$string[$i+1] == "Dž" ) OR
									 ( $string[$i].$string[$i+1] == "lj" OR $string[$i].$string[$i+1] == "Lj" ) OR 
									 ( $string[$i].$string[$i+1] == "nj" OR $string[$i].$string[$i+1] == "Nj" ) OR
									 ( $string[$i].$string[$i+1] == "č"  OR $string[$i].$string[$i+1] == "Č"  ) OR
									 ( $string[$i].$string[$i+1] == "ć"  OR $string[$i].$string[$i+1] == "Ć"  ) OR
									 ( $string[$i].$string[$i+1] == "đ"  OR $string[$i].$string[$i+1] == "Đ"  ) OR
									 ( $string[$i].$string[$i+1] == "š"  OR $string[$i].$string[$i+1] == "Š"  ) OR
									 ( $string[$i].$string[$i+1] == "ž"  OR $string[$i].$string[$i+1] == "Ž"  ) )
								)
		{
			
			switch($string[$i].$string[$i+1])
			{
				case 'dž':
						$kon_string .= "џ";
						break;
				case 'Dž':
						$kon_string .= "Џ";
						break;

				case 'lj':
						$kon_string .= "љ";
						break;
				case 'Lj':
						$kon_string .= "Љ";
						break;

				case 'nj':
						$kon_string .= "њ";
						break;
				case 'Nj':
						$kon_string .= "Њ";
						break;

				case 'č':
						$kon_string .= "ч";
						break;
				case 'Č':
						$kon_string .= "Ч";
						break;

				case 'ć':
						$kon_string .= "ћ";
						break;
				case 'Ć':
						$kon_string .= "Ћ";
						break;

				case 'đ':
						$kon_string .= "ђ";
						break;
				case 'Đ':
						$kon_string .= "Ђ";
						break;

				case 'š':
						$kon_string .= "ш";
						break;
				case 'Š':
						$kon_string .= "Ш";
						break;

				case 'ž':
						$kon_string .= "ж";
						break;
				case 'Ž':
						$kon_string .= "Ж";
						break;

			}

			$i++;

		} else {
			switch ($string[$i]) 
			{
				case 'a':
					$kon_string .= "а";
					break;

				case 'b':
					$kon_string .= "б";
					break;

				case 'c':
					$kon_string .= "ц";
					break;

				case 'd':
					$kon_string .= "д";
					break;

				case 'e':
					$kon_string .= "е";
					break;

				case 'f':
					$kon_string .= "ф";
					break;

				case 'g':
					$kon_string .= "г";
					break;

				case 'h':
					$kon_string .= "х";
					break;

				case 'i':
					$kon_string .= "и";
					break;

				case 'j':
					$kon_string .= "ј";
					break;

				case 'k':
					$kon_string .= "к";
					break;

				case 'l':
					$kon_string .= "л";
					break;

				case 'm':
					$kon_string .= "м";
					break;

				case 'n':
					$kon_string .= "н";
					break;

				case 'o':
					$kon_string .= "о";
					break;

				case 'p':
					$kon_string .= "п";
					break;

				case 'r':
					$kon_string .= "р";
					break;

				case 's':
					$kon_string .= "с";
					break;

				case 't':
					$kon_string .= "т";
					break;

				case 'u':
					$kon_string .= "у";
					break;

				case 'v':
					$kon_string .= "в";
					break;

				case 'z':
					$kon_string .= "з";
					break;
				
	//---------------------------------------------------------------VELIKA SLOVA

				case 'A':
					$kon_string .= "А";
					break;

				case 'B':
					$kon_string .= "Б";
					break;

				case 'C':
					$kon_string .= "Ц";
					break;				

				case 'D':
					$kon_string .= "Д";
					break;

				case 'E':
					$kon_string .= "Е";
					break;

				case 'F':
					$kon_string .= "Ф";
					break;

				case 'G':
					$kon_string .= "Г";
					break;

				case 'H':
					$kon_string .= "Х";
					break;

				case 'I':
					$kon_string .= "И";
					break;

				case 'J':
					$kon_string .= "Ј";
					break;

				case 'K':
					$kon_string .= "К";
					break;

				case 'L':
					$kon_string .= "Л";
					break;

				case 'M':
					$kon_string .= "М";
					break;

				case 'N':
					$kon_string .= "Н";
					break;

				case 'O':
					$kon_string .= "О";
					break;

				case 'P':
					$kon_string .= "П";
					break;

				case 'R':
					$kon_string .= "Р";
					break;

				case 'S':
					$kon_string .= "С";
					break;

				case 'T':
					$kon_string .= "Т";
					break;

				case 'U':
					$kon_string .= "У";
					break;

				case 'V':
					$kon_string .= "В";
					break;

				case 'Z':
					$kon_string .= "З";
					break;

				
				
				default:
					$kon_string .= "/"; // unos delimitera
					
					
					break;
			}
		}
	}

	return $kon_string;
}

// uzima vrednosti iz asoc niza (hash map) i treba da radi i sa cirilicom i sa latinicom
// function cir_u_lat($string)
// {
// 	$konvertovan_string = "";

// 	$lat_mala = array('а' => "a", 'б' => "b", 'ц' =>  "c", 'ч' =>  "č", 'ћ' =>  "ć", 'д' =>  "d",  'џ' =>  "dž", 'ђ' =>  "đ", 'е' =>  "e",  'ф' =>  "f", 'г' =>  "g", 
// 		              'х' => "h", 'и' => "i", 'ј' =>  "j", 'к' =>  "k", 'л' =>  "l", 'љ' =>  "lj", 'м' =>  "m",  'н' =>  "n", 'њ' =>  "nj", 'о' =>  "o", 'п' =>  "p", 
// 		              'р' => "r", 'с' => "s", 'ш' =>  "š", 'т' =>  "t", 'у' =>  "u", 'в' =>  "v",  'з' =>  "z",  'ж' =>  "ž");

// 	$lat_velika = array('А' => "A", 'Б' => "B", 'Ц' =>  "C", 'Ч' =>  "Č", 'Ћ' =>  "Ć", 'Д' =>  "D",  'Џ' =>  "Dž", 'Ђ' =>  "Đ", 'Е' =>  "E",  'Ф' =>  "F", 'Г' =>  "G", 
// 		                'Х' => "H", 'И' => "I", 'Ј' =>  "J", 'К' =>  "K", 'Л' =>  "L", 'Љ' =>  "Lj", 'М' =>  "M",  'Н' =>  "N", 'Њ' =>  "Nj", 'О' =>  "O", 'П' =>  "P", 
// 		                'Р' => "R", 'С' => "S", 'Ш' =>  "Š", 'Т' =>  "T", 'У' =>  "U", 'В' =>  "V",  'З' =>  "Z",  'Ж' =>  "Ž");

// 	for($i = 0; $i < strlen($string); $i++)
// 	{
// 		if (in_array($string[$i], $lat_mala) ) 
// 		{
// 			$slovo = array_search($string[$i], $lat_mala);
// 			$konvertovan_string .= $string[$i];
// 		}
// 	}
// 	// var_dump("а");
// }

// cir_u_lat("asfdgh");
// print_r(lat_u_cir("đš po povđć09raćtra"));
// var_dump( mb_strlen("АС П") );

// $string_c = "Нека реченица која служи као тест.";

// $string_l = "Neka rečenica koja služi kao test.";

// var_dump(lat_u_cir($string_l));

// var_dump( explode ( "/", lat_u_cir($string_l) ) );

?>
