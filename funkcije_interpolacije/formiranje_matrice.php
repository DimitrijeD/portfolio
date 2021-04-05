<?php
// ----------------------------------------------------------------------------------------------------------------------------------------------------

// FORMIRANJE MATRICE
function formiranje_matrice($niz_cvorovi, $niz_intervali)
{
	$matrica = array();
	$br_cvorova = count($niz_cvorovi);
	$niz_cvorovi_za_matricu = niz_cvorovi_za_matricu($niz_cvorovi);
	$unutrasnji_cvorovi = unutrasnji_cvorovi($niz_cvorovi);

	// velicina reda matrice, kolona je samo + 1 za rezultate
	$dimenzija_matrice_r = 2 * ($br_cvorova - 1) + ($br_cvorova - 2) + 1;

	for($k = 0, $r = 0; 	$k < $dimenzija_matrice_r; 		$k = $k + 3, $r++)
	{

		// -------------------------------------PAROVI------------------------------------//
		// $niz_cvorovi_za_matricu[$r] je: 												  //
		// 		vrednost X, -a koji se mnozi sa koeficijentima							  //
		// 		vrednost Y, -a koji je rezultat formule 								  //

		$matrica[$r] = formiraj_red($k, $niz_cvorovi_za_matricu[$r], $dimenzija_matrice_r);

		++$r;

		$matrica[$r] = formiraj_red($k, $niz_cvorovi_za_matricu[$r], $dimenzija_matrice_r);
		
		//																				  //
		// -------------------------------------------------------------------------------//
		
	}

	// odavde treba da nastavi, za unutrasnje cvorove
	$nastavak = pocetak_unutrasnjih($matrica) + 1;

	// - 1 jer je poslednja funkcija a1 = 0
	// mogao sa isto tako da loopujem za svaki od unutrasnji_cvorovi, ali rezultat je isti, ovako je mozda sigurnije, cim ovakve stvari kucam, sigurno nesto kasnije nece biti kako treba
	for($k = 0, $r = $nastavak, $cv = 0; 	$r < $dimenzija_matrice_r - 1; 		$k = $k + 3, $r++, $cv++)
	{
		// $unutrasnji_cvorovi[$cv][0] - je vrednost X-a unutrasnjeg/ih cvorova
		$matrica[$r] = formiraj_red_unutrasnji($k, $unutrasnji_cvorovi[$cv][0], $dimenzija_matrice_r); 
	}

	// poslednja formula a1 = 0
	$kraj = pocetak_unutrasnjih($matrica) + 1;

	$matrica[$kraj] = poslednja_formula($dimenzija_matrice_r);

	return $matrica;
}

// ----------------------------------------------------------------------------------------------------------------------------------------------------



// ----------------------------------------------------------------------------------------------------------------------------------------------------
/*
function niz_tacke($tacke_x)
{
	$rez = array();
	$niz_tacke = explode("/", $tacke_x);

	for($i = 0; $i < count($niz_tacke); $i++)
	{
		$rez[$i] = trim($niz_tacke[$i]);
		$rez[$i] = (float)$rez[$i];
	}
	return $rez;
}
*/
// ----------------------------------------------------------------------------------------------------------------------------------------------------

function niz_intervali($niz_cvorovi)
{
	$niz_intervali = array();

	for($i = 0; $i < count($niz_cvorovi); $i++)
	{
		if(isset($niz_cvorovi[$i+1]))
		{
			$niz_intervali[] = array($niz_cvorovi[$i][0], $niz_cvorovi[$i+1][0]);
		}
	}

	return $niz_intervali;
}

// ----------------------------------------------------------------------------------------------------------------------------------------------------

// bubble sort
// radi rekurzinvo, kao vrti skriptu i ne vraca rez, ovde je neki problem
function sortiranje_cvorova_po_intervalu($cvorovi)
{
	for($i = 0; $i < count($cvorovi); $i++)
	{
		if( isset($cvorovi[$i + 1]) ) 
		{
			if($cvorovi[$i][0] > $cvorovi[$i + 1][0])
			{
				$temp1 = $cvorovi[$i];
				$temp2 = $cvorovi[$i + 1];

				$cvorovi[$i] = $temp2;
				$cvorovi[$i + 1] = $temp1;
			}
		}
	}

	// provera da li je dobro sortiran
	for($n = 0; $n < count($cvorovi); $n++)
	{
		if( isset($cvorovi[$n + 1]) )
		{
			if( $cvorovi[$n][0] > $cvorovi[$n + 1][0] )
			{
				$cvorovi = sortiranje_cvorova_po_intervalu($cvorovi);
			}
		}
	}

	return $cvorovi;
}


// ----------------------------------------------------------------------------------------------------------------------------------------------------
// kad mi je ovo iz prve uspelo, god mode activated

function formiraj_red($k, $cvor, $dimenzija_matrice_r)
{
	$red_matrice = array();
	$red_matrice[$k]     = $cvor[0] * $cvor[0];        // a
	$red_matrice[$k + 1] = $cvor[0];				   // b
	$red_matrice[$k + 2] = 1;						   // c
	$red_matrice[$dimenzija_matrice_r] = $cvor[1]; //rezultat

	$red_matrice = popunjavanje_preostalih_polja_nulama($red_matrice, $dimenzija_matrice_r);
	ksort($red_matrice);

	return $red_matrice;
}

// ----------------------------------------------------------------------------------------------------------------------------------------------------

function formiraj_red_unutrasnji($k, $x, $dimenzija_matrice_r)
{
	$red_matrice = array();

	$red_matrice    [$k] = 2 * $x;
	$red_matrice[$k + 1] = 1;

	$red_matrice[$k + 2] = 0; // nije potrebno al ajde

	$red_matrice[$k + 3] = -2 * $x;
	$red_matrice[$k + 4] = -1;
																			// + 1 jer su nule resenja ovih formula
	$red_matrice = popunjavanje_preostalih_polja_nulama($red_matrice, $dimenzija_matrice_r + 1);
	ksort($red_matrice);

	return $red_matrice;
}

// ----------------------------------------------------------------------------------------------------------------------------------------------------

function poslednja_formula($dimenzija_matrice_r)
{
	$poslednja = array( 0 => 1 );
																	// + 1 jer je 0 resenje ove formule
	$poslednja = popunjavanje_preostalih_polja_nulama($poslednja, $dimenzija_matrice_r + 1);
	ksort($poslednja);

	return $poslednja;
}

// ----------------------------------------------------------------------------------------------------------------------------------------------------

// input cvorovi DAKLE SVI SU DUPLIRANI OSIM PRVOG I POSLEDNJEG CVORA
// output  (x1,y1)   (x2,y2), (x2,y2)   (x3,y3), (x3,y3) ... (xn-1,yn-1), (xn-1,yn-1),   (xn,yn) 
// zato se unsetuyje 0 i uklanja poslednji elem niza
function niz_cvorovi_za_matricu($niz_cvorovi)
{
	$niz_cvorovi_za_matricu = array();
	for($i = 0; $i < count($niz_cvorovi); $i++)
	{										// X 					// Y
		$niz_cvorovi_za_matricu[] = array($niz_cvorovi[$i][0], $niz_cvorovi[$i][1]);
		$niz_cvorovi_za_matricu[] = array($niz_cvorovi[$i][0], $niz_cvorovi[$i][1]);
	}
	array_pop($niz_cvorovi_za_matricu);
	unset($niz_cvorovi_za_matricu[0]);
	$niz_cvorovi_za_matricu = array_values($niz_cvorovi_za_matricu);

	return $niz_cvorovi_za_matricu;
}

// ----------------------------------------------------------------------------------------------------------------------------------------------------

function popunjavanje_preostalih_polja_nulama($red_matrice, $dimenzija_matrice_r)
{
	for($i = 0; $i < $dimenzija_matrice_r; $i++)
	{
		if( !isset($red_matrice[$i]) )
		{
			$red_matrice[$i] = 0;
		}
	}
	return $red_matrice;
}

// ----------------------------------------------------------------------------------------------------------------------------------------------------

function pocetak_unutrasnjih($niz)
{
	end($niz);        
	$kljuc = key($niz); 
	return $kljuc;
}

// ----------------------------------------------------------------------------------------------------------------------------------------------------

function unutrasnji_cvorovi($niz_cvorovi)
{
	unset($niz_cvorovi[0]);
	array_pop($niz_cvorovi);
	$niz_cvorovi = array_values($niz_cvorovi);
	return $niz_cvorovi;
}

// ----------------------------------------------------------------------------------------------------------------------------------------------------


// ----------------------------------------------------------------------------------------------------------------------------------------------------

?>