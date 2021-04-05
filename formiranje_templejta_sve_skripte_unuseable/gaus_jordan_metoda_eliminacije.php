<?php

$matrica = array(
	array(  0,  0, 1,   0,  0, 0,   0,  0,   0,      0,     0,    0,      0,    0, 0,      0),  // a1
	array(100, 10, 1,   0,  0, 0,   0,  0,   0,      0,     0,    0,      0,    0, 0, 227.04),  // b1 
	array(  0,  0, 0, 100, 10, 1,   0,  0,   0,      0,     0,    0,      0,    0, 0, 227.04),  // c1 
	array(  0,  0, 0, 225, 12, 1,   0,  0,   0,      0,     0,    0,      0,    0, 0, 362.78),  // a2 
	array(  0,  0, 0,   0,  0, 0, 225, 12,   1,      0,     0,    0,      0,    0, 0, 362.78),  // b2 
	array(  0,  0, 0,   0,  0, 0, 400, 20,   1,      0,     0,    0,      0,    0, 0, 517.35),  // c2 
	array(  0,  0, 0,   0,  0, 0,   0,  0,   0,    400,    20,    1,      0,    0, 0, 517.35),  // a3 
	array(  0,  0, 0,   0,  0, 0,   0,  0,   0, 506.23,  22.5,    1,      0,    0, 0, 602.97),  // b3 
	array(  0,  0, 0,   0,  0, 0,   0,  0,   0,      0,     0,    0, 506.23, 22.5, 1, 602.97),  // c3 
	array(  0,  0, 0,   0,  0, 0,   0,  0,   0,      0,     0,    0,    900,   30, 1, 901.67),  // a4
	array( 20,  1, 0, -20, -1, 0,   0,  0,   0,      0,     0,    0,      0,    0, 0,      0),  // b4  
	array(  0,  0, 0,  30,  1, 0, -30, -1,   0,      0,     0,    0,      0,    0, 0,      0),  // c4 
	array(  0,  0, 0,   0,  0, 0,  40,  1,   0,    -40,    -1,    0,      0,    0, 0,      0),  // a5 
	array(  0,  0, 0,   0,  0, 0,   0,  0,   0,     45,     1,    0,    -45,   -1, 0,      0),  // b5 
	array(  1,  0, 0,   0,  0, 0,   0,  0,   0,      0,     0,    0,      0,    0, 0,      0)	  // c5 
);	



// -----------------------------------------------------------------------------------------------------------------------------------------------------
/*
function gaus_jordan_metoda_eliminacije($matrica)
{

	// broj redova matrice
	$max_red    = count($matrica);
	// broj kolona matrice
	$max_kolona = count($matrica[0]);

	$niz_elemenata_glavne_dijagonale = glavna_dijagonala($max_red);

	$matrica = glavna_dijagonala_sort_not_null($niz_elemenata_glavne_dijagonale);

	for($polje_dijagonale = 0; $polje_dijagonale < count($niz_elemenata_glavne_dijagonale); $polje_dijagonale++)
	{
		$red_d    = $niz_elemenata_glavne_dijagonale[$polje_dijagonale][0];
		$kolona_d = $niz_elemenata_glavne_dijagonale[$polje_dijagonale][1];

		// polje dijagonale mora biti razlicito od nule, ali ako nije, U IF treba da se zameni red sa nekim drugim redom koji nema nulu na toj koloni
		if (glavna_dijagona_nula($matrica, $red_d, $kolona_d)) 
		{
			// preuredjivanje niza tako da nakon IF-a polje glavne dijagonale bude ne nula

		}
	}


}
*/
// -----------------------------------------------------------------------------------------------------------------------------------------------------

// funkcija proverava da li su sve nule ispod i iznad glavne dijagonale za odredjen element dijagonale
// $red_d    - red dijagonale
// $kolona_d - kolona dijagonale
// ako naidje na ne nula vrednost ispod ili iznad glavne dijagonale, vraca niz (red, kolona) tog elementa
// u suprotnom vraca FALSE sto znaci da su sve NULE OKO DIJAGONALE, moze se preci na sledecu kolonu
function nije_nula_ispod_glavne_d($matrica, $red_d, $kolona_d, $max_red)
{
	for($r = $red_d; $r < $max_red; $r++)
	{
		// posmatrano polje nije na glavnoj dijagonali
		if($r != $red_d )
		{
			if ($matrica[$r][$kolona_d] != 0)
			{
				// ovaj element nije nula i nije na glavnoj dijagonali
				return array($r, $kolona_d);
			}
		}
	}

	// sve su nule ispod i iznad glavne dijagonale
	return FALSE;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

// funkcija vraca niz polja glavne dijagonale
function glavna_dijagonala($max_red)
{
	$elementi_glavne_dijagonale = array();
	// za neku matricu r*k, potrebno je r ispod i iznad glavne dijagonale
	for ($i = 0; $i < $max_red ; $i++)
	{
		$elementi_glavne_dijagonale[] = $i;
	}
	return $elementi_glavne_dijagonale;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

// fja sortira matricu tako da glavna dijagonala nije nula 
function sort_gl_dijagonala_($matrica)
{
	// dodat string kao identifikator promenljive za svoj red, kao sto su komentari gore u primeru $matrica ;
	$matrica = promenljive_sistema_jednacina($matrica,5);

	// broj redova matrice
	$max_red    = count($matrica);

	// broj kolona matrice
	$max_kolona = count($matrica[0]);

	$sorted = array();
	$fiksirani_redovi = array();
	$glavna_dijagonala = glavna_dijagonala($max_red);

	// prvo postaviti linearne 
	$linearni_vektori = linearni_vektori($matrica);
	for($i = 0; $i < count($linearni_vektori); $i++)
	{
		// RED matrice u kojoj se nalazi linearni vektor
		$red_matrice_lin = $linearni_vektori[$i][0][0];

		// KOLONA matrice u kojoj se nalazi linearni vektor
		$kolona_matrice_lin = $linearni_vektori[$i][0][1];

		$temp = $matrica[$red_matrice_lin];
		$sorted[$kolona_matrice_lin] = $temp;
		$fiksirani_redovi[] = $kolona_matrice_lin;
		// gl dijagonala trimovana iskoriscenim gl poljima
		$glavna_dijagonala = ne_sortirani_delovi_dijagonale($fiksirani_redovi, $glavna_dijagonala);
	}

	ksort($sorted);
	
	$uslov = count($glavna_dijagonala);
	
	$n = 2;
	for ($br_dijagonale = 0; $br_dijagonale < $uslov; $br_dijagonale++) 
	{ 
		$sorted_gd = vise_ne_nula_u_redu($n, $matrica, $glavna_dijagonala, $sorted);

		if($sorted_gd)
		{
			$sorted = $sorted_gd[0];
			$glavna_dijagonala = $sorted_gd[1]; 
			// mozda nije potrebno sortirati po kljucu ali ne moze da skodi
			// ksort($sorted);
			// exit();
			// ksort($sorted);
			// print_r($sorted);
		}	
	}
	ksort($sorted);
	// print_r($sorted);
	return $sorted;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------
// fj uklanja sortirane (postavljene) redove iz niza glavnih dijagonala
function ne_sortirani_delovi_dijagonale($fiksirani_redovi, $glavna_dijagonala)
{
	for($i = 0; $i < count($fiksirani_redovi); $i++)
	{
		$kljuc = NULL;
		$kljuc = array_search($fiksirani_redovi[$i], $glavna_dijagonala);

		if(isset($glavna_dijagonala[$kljuc]))
		{
			unset($glavna_dijagonala[$kljuc]);
		}
	}
	return $glavna_dijagonala;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------
// samo za slucajeve kada u matrici postoji red u kom postoji jedan ne nula broj, a mora da postoje bar 2 koja predstavljaju linearne vektore
function linearni_vektori($matrica)
{
	$svi_linearni = array();
	for($r = 0; $r < count($matrica); $r++)
	{
		$polja = array();
		for($k = 0; $k < count($matrica); $k++)
		{
			if($matrica[$r][$k] != 0)
			{
				array_push($polja, array($r, $k));
			}
		}
		if(count($polja) == 1)
		{
			array_push($svi_linearni, $polja);
		}
	}
	if (!empty( $svi_linearni ) ){
		return $svi_linearni;
	}else{
		return FALSE;
	}
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

// fja pronalazi (od pocetka) red matrice u kom ima $n broj ne nula vrednosti, ako je bar jedan od tih redova u $glavna_dijagonala, taj red se stavlja u 
// $sorted matricu na red koji je jednak koloni 
function vise_ne_nula_u_redu($n, $matrica, $glavna_dijagonala, $sorted)
{
	$uspeh = FALSE;
	for($k = 0; $k < count($matrica); $k++)
	{
		// broj ne nula vrednosti u toj koloni
		$not_null = array();

		
		for($r = 0; $r < count($matrica); $r++)
		{
			if($matrica[$r][$k] != 0)
			{
				$not_null[] = array($r, $k);
			}
		}
		
		if(count($not_null) === $n)
		{
			print_r(count($not_null)); echo "<br>"; 
			$red_za_unos = red_nije_u_sorted($not_null, $glavna_dijagonala);
			if($red_za_unos)
			{
				$sorted = unos_reda_u_sorted($red_za_unos, $matrica, $sorted);
				$glavna_dijagonala = ciscenje_glavne_dijagonale($glavna_dijagonala, $red_za_unos);
				$uspeh = TRUE;
				 // ksort($sorted);
				// print_r($sorted );
				// exit();
				// echo "<br>";echo "<br>";echo "<br>";
			}
		}

	}
	if($uspeh){
		return array($sorted, $glavna_dijagonala) ;
	} else {
		return FALSE;
	}
	

}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

// za 2,3,4... brisanje iz glavne dijagonale
function ciscenje_glavne_dijagonale($glavna_dijagonala, $red_za_unos)
{
	unset($glavna_dijagonala[$red_za_unos[0]]);
	return $glavna_dijagonala;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

// unos reda u sorted
function unos_reda_u_sorted($red_za_unos, $matrica, $sorted)
{

	$temp = $matrica[$red_za_unos[0]];
	$sorted[$red_za_unos[1]] = $temp; 
	return $sorted;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

// promenljive sistema jednacina
function promenljive_sistema_jednacina($matrica, $broj_cvorova)
{
	$i = 1;
	for($r = 0; $r < count($matrica); $r++)
	{
		// za svaki cvor trebaju 3 promenljive
		
		$prva  = "a{$i}";
		array_push($matrica[$r], $prva);

		$druga = "b{$i}";
		array_push($matrica[++$r], $druga);

		$treca = "c{$i}";
		array_push($matrica[++$r], $treca);

		$i++;
	}
	return $matrica;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

// da li je barem jedan $r red u $glavna_diojagonala, ako jeste, znaci taj red nije u sorted(koji god da je), moze se uneti u sorted
function red_nije_u_sorted($not_null, $glavna_dijagonala)
{
	for($i = 0; $i < count($not_null); $i++)
	{
		if(in_array($not_null[$i][0], $glavna_dijagonala))
		{
			// polje (r,k) matrice koje moze da se stavi u sorted
			return $not_null[$i];
		}
	}
	
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

/*
function x_u_redu($matrica, $x)
{
	
	for($k = 0; $k < count($matrica); $k++)
	{
		$broj_ne_nula_elemenata = 0;
		$redovi = array();

		for($r = 0; $r < count($matrica); $r++)
		{
			if($matrica[$r][$k] != 0)
			{
				$broj_ne_nula_elemenata++;
				array_push($redovi, array($r, $k) );
			}
		}
		if($broj_ne_nula_elemenata == $x)
		{
			return $redovi;
		} else {
			echo "ne postoji {$x} trazeni broj elemenata u koloni";
			
		}	
	}
	return false;
	
}
*/

// -----------------------------------------------------------------------------------------------------------------------------------------------------

// print("<pre>");
// print_r( x_u_redu($matrica, 4));

// provera da li je element glavne dijagonale 0, vraca TRUE STO ZNACI DA  taj red mora da se zameni sa nekim koji
function glavna_dijagona_nula($matrica, $red_d, $kolona_d)
{
	if($matrica[$red_d][$kolona_d] == 0)
	{
		return TRUE;
	} else {
		return FALSE;
	}
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

/*
// sortiranje matrice tako da glavna dijagonala nema nule
function  glavna_dijagonala_sort_not_null($niz_elemenata_glavne_dijagonale, $matrica)
{
	for($polje_dijagonale = 0; $polje_dijagonale < count($niz_elemenata_glavne_dijagonale); $polje_dijagonale++)
	{
		$red_d    = $niz_elemenata_glavne_dijagonale[$polje_dijagonale][0];
		$kolona_d = $niz_elemenata_glavne_dijagonale[$polje_dijagonale][1];

		if ( glavna_dijagona_nula($matrica, $red_d, $kolona_d) )
		{
			if(nije_nula_ispod_glavne_d($matrica, $red_d, $kolona_d, $max_red))
			{
				$polje_nije_nula = nije_nula_ispod_glavne_d($matrica, $red_d, $kolona_d, $max_red);
			} else {
				echo "nesto opasno nije u redu...";
				exit();
			}

		}
	}
}
*/

// -----------------------------------------------------------------------------------------------------------------------------------------------------

// gaus_jordan_metoda_eliminacije($matrica);

// sort_gl_dijagonala_($matrica);
// print_r(glavna_dijagonala(15));

?>