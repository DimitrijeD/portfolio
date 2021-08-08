<?php

// treba da primi ceo red tabele sa strukturom asocjativnog niza: 
// id, id_korisnika, reci_osmosmerke, niz_osmosmerke, unet_red, unet_kolona, resenje_osmosmerke
// gde su 
// id - id osmosmerke
// id_korisnika -id_korisnika
// reci_osmosmerke - reci koje su unete u osmosmerku - ne secam se da li u bazu unosi reci koje je korisnik upisao u formu,najverovatnije da, jer je ovaj 
// 		string napravljen od osmosmerka_niz u formatu:
	// rec1/rec2/rec3... recn/ obratiti paznju
//  red
// kolona
// resenje_osmosmerke - string reci koja predstavlja resenje - u bazi je velikim slovima

// svrha funkcije je da :
//		napravi niz slova osmosmerke od stringa niz_osmosmerke


function formiraj_osmosmerku_iz_baze($red_tabele) // 
{
	$niz_osmosmerke_string = $red_tabele['niz_osmosmerke']; // iz napravljene osmosmerke
	// var_dump($niz_osmosmerke_string);
	$red = $red_tabele['unet_red'];
	$kolona = $red_tabele['unet_kolona'];

	$broj_stringa = 0;

	$osmosmerka_niz = array();

	for($r = 1; $r <= $red; $r++ )
	{
		// $osmosmerka_niz = array( $red => array() ); // instanciranje niza

		for($k = 1; $k <= $kolona; $k++ )
		{
			$slovo = $niz_osmosmerke_string[$broj_stringa].$niz_osmosmerke_string[++$broj_stringa];
			$broj_stringa++; // xd
			$osmosmerka_niz[$r][$k] = $slovo; // za cirilicno pismo samo jer spaja dva susedna bajta
		}
	}
	
	return $osmosmerka_niz;
}

?>