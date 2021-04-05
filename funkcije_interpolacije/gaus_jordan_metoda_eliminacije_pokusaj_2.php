<?php
// include 'sortiranje_po_glavnoj_dijagonali.php';

// slucaj sa http://mathforcollege.com/nm/mws/gen/05inp/mws_gen_inp_ppt_spline.pdf
/*
$matrica = array(
	array(  0,  0, 1,   0,  0, 0,   0,  0,   0,      0,     0,    0,      0,    0, 0,      0),  // a1
	array(100, 10, 1,   0,  0, 0,   0,  0,   0,      0,     0,    0,      0,    0, 0, 227.04),  // b1 
	array(  0,  0, 0, 100, 10, 1,   0,  0,   0,      0,     0,    0,      0,    0, 0, 227.04),  // c1 
	array(  0,  0, 0, 225, 15, 1,   0,  0,   0,      0,     0,    0,      0,    0, 0, 362.78),  // a2 
	array(  0,  0, 0,   0,  0, 0, 225, 15,   1,      0,     0,    0,      0,    0, 0, 362.78),  // b2 
	array(  0,  0, 0,   0,  0, 0, 400, 20,   1,      0,     0,    0,      0,    0, 0, 517.35),  // c2 
	array(  0,  0, 0,   0,  0, 0,   0,  0,   0,    400,    20,    1,      0,    0, 0, 517.35),  // a3 
	array(  0,  0, 0,   0,  0, 0,   0,  0,   0, 506.25,  22.5,    1,      0,    0, 0, 602.97),  // b3 
	array(  0,  0, 0,   0,  0, 0,   0,  0,   0,      0,     0,    0, 506.25, 22.5, 1, 602.97),  // c3 
	array(  0,  0, 0,   0,  0, 0,   0,  0,   0,      0,     0,    0,    900,   30, 1, 901.67),  // a4
	array( 20,  1, 0, -20, -1, 0,   0,  0,   0,      0,     0,    0,      0,    0, 0,      0),  // b4  
	array(  0,  0, 0,  30,  1, 0, -30, -1,   0,      0,     0,    0,      0,    0, 0,      0),  // c4 
	array(  0,  0, 0,   0,  0, 0,  40,  1,   0,    -40,    -1,    0,      0,    0, 0,      0),  // a5 
	array(  0,  0, 0,   0,  0, 0,   0,  0,   0,     45,     1,    0,    -45,   -1, 0,      0),  // b5 
	array(  1,  0, 0,   0,  0, 0,   0,  0,   0,      0,     0,    0,      0,    0, 0,      0)	// c5 
);
*/
 

/*							------------------------- 		RESENJE 		------------------------
Array ( 
 [0] => Array ( [0] => 1 [1] => 0 [2] => 0 [3] => 0 [4] => 0 [5] => 0 [6] => 0 [7] => 0 [8] => 0 [9] => 0 [10] => 0 [11] => 0 [12] => 0 [13] => 0 [14] => 0 [15] => 0                [16] => c5 ) 
 [1] => Array ( [0] => 0 [1] => 1 [2] => 0 [3] => 0 [4] => 0 [5] => 0 [6] => 0 [7] => 0 [8] => 0 [9] => 0 [10] => 0 [11] => 0 [12] => 0 [13] => 0 [14] => 0 [15] => 22.704           [16] => b1 ) 
 [2] => Array ( [0] => 0 [1] => 0 [2] => 1 [3] => 0 [4] => 0 [5] => 0 [6] => 0 [7] => 0 [8] => 0 [9] => 0 [10] => 0 [11] => 0 [12] => 0 [13] => 0 [14] => 0 [15] => 0                [16] => a1 ) 
 [3] => Array ( [0] => 0 [1] => 0 [2] => 0 [3] => 1 [4] => 0 [5] => 0 [6] => 0 [7] => 0 [8] => 0 [9] => 0 [10] => 0 [11] => 0 [12] => 0 [13] => 0 [14] => 0 [15] => 0.8888           [16] => a2 ) 
 [4] => Array ( [0] => 0 [1] => 0 [2] => 0 [3] => 0 [4] => 1 [5] => 0 [6] => 0 [7] => 0 [8] => 0 [9] => 0 [10] => 0 [11] => 0 [12] => 0 [13] => 0 [14] => 0 [15] => 4.928            [16] => b4 ) 
 [5] => Array ( [0] => 0 [1] => 0 [2] => 0 [3] => 0 [4] => 0 [5] => 1 [6] => 0 [7] => 0 [8] => 0 [9] => 0 [10] => 0 [11] => 0 [12] => 0 [13] => 0 [14] => 0 [15] => 88.88            [16] => c1 ) 
 [6] => Array ( [0] => 0 [1] => 0 [2] => 0 [3] => 0 [4] => 0 [5] => 0 [6] => 1 [7] => 0 [8] => 0 [9] => 0 [10] => 0 [11] => 0 [12] => 0 [13] => 0 [14] => 0 [15] => -0.1356          [16] => c2 ) 
 [7] => Array ( [0] => 0 [1] => 0 [2] => 0 [3] => 0 [4] => 0 [5] => 0 [6] => 0 [7] => 1 [8] => 0 [9] => 0 [10] => 0 [11] => 0 [12] => 0 [13] => 0 [14] => 0 [15] => 35.66            [16] => c4 ) 
 [8] => Array ( [0] => 0 [1] => 0 [2] => 0 [3] => 0 [4] => 0 [5] => 0 [6] => 0 [7] => 0 [8] => 1 [9] => 0 [10] => 0 [11] => 0 [12] => 0 [13] => 0 [14] => 0 [15] => -141.61          [16] => b2 ) 
 [9] => Array ( [0] => 0 [1] => 0 [2] => 0 [3] => 0 [4] => 0 [5] => 0 [6] => 0 [7] => 0 [8] => 0 [9] => 1 [10] => 0 [11] => 0 [12] => 0 [13] => 0 [14] => 0 [15] => 1.6048           [16] => b3 ) 
[10] => Array ( [0] => 0 [1] => 0 [2] => 0 [3] => 0 [4] => 0 [5] => 0 [6] => 0 [7] => 0 [8] => 0 [9] => 0 [10] => 1 [11] => 0 [12] => 0 [13] => 0 [14] => 0 [15] => -33.955999999999 [16] => a5 ) 
[11] => Array ( [0] => 0 [1] => 0 [2] => 0 [3] => 0 [4] => 0 [5] => 0 [6] => 0 [7] => 0 [8] => 0 [9] => 0 [10] => 0 [11] => 1 [12] => 0 [13] => 0 [14] => 0 [15] => 554.54999999999  [16] => a3 ) 
[12] => Array ( [0] => 0 [1] => 0 [2] => 0 [3] => 0 [4] => 0 [5] => 0 [6] => 0 [7] => 0 [8] => 0 [9] => 0 [10] => 0 [11] => 0 [12] => 1 [13] => 0 [14] => 0 [15] => 0.2088888888889  [16] => a4 ) 
[13] => Array ( [0] => 0 [1] => 0 [2] => 0 [3] => 0 [4] => 0 [5] => 0 [6] => 0 [7] => 0 [8] => 0 [9] => 0 [10] => 0 [11] => 0 [12] => 0 [13] => 1 [14] => 0 [15] => 28.86            [16] => b5 ) 
[14] => Array ( [0] => 0 [1] => 0 [2] => 0 [3] => 0 [4] => 0 [5] => 0 [6] => 0 [7] => 0 [8] => 0 [9] => 0 [10] => 0 [11] => 0 [12] => 0 [13] => 0 [14] => 1 [15] => -152.12999999999 [16] => c3 ) )

Array ( 
[0] => Array ( [0] => 4 [1] => 15.333333333333 ) 
[1] => Array ( [0] => 5 [1] => 18.666666666667 ) 
[2] => Array ( [0] => 7 [1] => 29.333333333333 )
[3] => Array ( [0] => 8 [1] => 44.666666666667 ) 
[4] => Array ( [0] => 10 [1] => 88.555555555556 ) 
[5] => Array ( [0] => 11 [1] => 95.555555555556 ) 
[6] => Array ( [0] => 3.5 [1] => 13.666666666667 ) 
[7] => Array ( [0] => 4.5 [1] => 17 ) 
[8] => Array ( [0] => 5.5 [1] => 20.333333333333 ) 
[9] => Array ( [0] => 6.7 [1] => 26.293333333333 ) 
[10] => Array ( [0] => 7.5 [1] => 36 ) 
[11] => Array ( [0] => 8.5 [1] => 55.333333333333 ) )
*/

/*
// ekstreman slucaj u kom postoji samo jedna kombinacija, kasnije sam dodao jos da proverim da li ima bugova
$matrica = array(
	array(0, 1, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 5), //a1
	array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 5), //b1
	array(0, 0, 0, 0, 0, 1, 1, 0, 1, 0, 0, 0, 5), //c1
	array(1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5), //a2
	array(0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 5), //b2
	array(0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5), //c2
	array(0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 5), //a3
	array(0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 5), //b3
	array(0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 5), //c3
	array(0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 5), //a4
	array(0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 5), //b4
	array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 5)  //c4

);
*/

/*
$matrica = array(
	array(1,  2,  3,  4),
	array(2,  1,  6,  8),
	array(4,  8,  1, 16)
);
*/


// -----------------------------------------------------------------------------------------------------------------------------------------------------

function gaus_jordan_metoda_eliminacije_pokusaj_2($niz_cvorovi, $tacke_x) // $matrica, 
{
	// ------------------------------------- Priprema matrice -----------------------------------//

	// FORMIRANJE MATRICE NA OSNOVU CVOROVA
	// $niz_cvorovi = niz_cvorovi($cvorovi);
    // $niz_tacke   = niz_tacke($tacke_x);
    $niz_tacke   = $tacke_x;
    // sortirani cvorovi po x vrednosti u rastucem poretku radi formiranja intervala
    $niz_cvorovi = sortiranje_cvorova_po_intervalu($niz_cvorovi);

    $niz_intervali = niz_intervali($niz_cvorovi);
    // var_dump($niz_intervali);
    $matrica = formiranje_matrice($niz_cvorovi, $niz_intervali);

    // -----------------------------------------------------------------------------------------//


	//---------------------------------- RESAVANJE SISTEMA JEDNACINA(matrice) ------------------//

	$matrica = sort_gl_dijagonala($matrica);
	// echo ( napravi_tabelu( $matrica ) );
	// exit();

	// echo ( napravi_tabelu( zaokruzi_koeficijente_za_prikaz ($matrica) ) );
	// exit();

	$matrica = gauss_nuliranje_matrice($matrica);

	$matrica = jordan_nuliranje_matrice($matrica);


	// -----------------------------------------------------------------------------------------//


	//------------------------ Formiranje konacnih formula za odgovarajuce intervale -----------//

	$niz_koeficijenata_sa_vrednostima = niz_koeficijenata_sa_vrednostima($matrica);
	$abc_grupe = abc_grupe($niz_koeficijenata_sa_vrednostima);
	// var_dump($abc_grupe);
	// var_dump($niz_koeficijenata_sa_vrednostima);
	$formule = formiraj_string_formula_sa_intervalima($niz_koeficijenata_sa_vrednostima);

	// ispisi formule
	for($form = 1; $form <= count($formule); $form++)
	{
		$formula_str = $formule[$form];
		$interval_levi  = $niz_intervali[$form - 1][0];
		$interval_desni = $niz_intervali[$form - 1][1];
		echo "Interval {$form}. je [{$interval_levi}, {$interval_desni}], a formula: {$formula_str} " . "<br>";
	}
	echo "<br>";
	// -----------------------------------------------------------------------------------------//


	// ------------------------------------Interpolacija----------------------------------------//
	$niz_interpoliranih_tacaka = array();
	if(!empty($niz_tacke))
	{
		for($x = 0; $x < count($niz_tacke); $x++)
		{
			// kriva
			$kr = u_kom_intervalu_je_input($niz_intervali, $niz_tacke[$x]) + 1; // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

			// Pn(x)	=			            x * x * An                         +           x * Bn                        +     Cn   
			$vrednost_y = ( $niz_tacke[$x] * $niz_tacke[$x] * $abc_grupe[$kr][0] ) + ( $niz_tacke[$x] * $abc_grupe[$kr][1] ) +  $abc_grupe[$kr][2];
			$niz_interpoliranih_tacaka[] = array($niz_tacke[$x], $vrednost_y);

			// $prvi = $niz_intervali[$u_kom_intervalu_je_input][0];
			// $drugi = $niz_intervali[$u_kom_intervalu_je_input][1];
			// $t = $niz_tacke[$x];
			// echo "{$x}. tacka - {$t} - je u intervalu: {$prvi}, {$drugi}" . "<br>";
		}
	}

	// -----------------------------------------------------------------------------------------//

	return array($matrica, $niz_interpoliranih_tacaka);
	
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

function gauss_nuliranje_matrice($matrica)
{
	for($r = 0; $r < count($matrica); $r++)
	{
		if($matrica[$r][$r] == 0)
		{
			// echo "PRE ZAMENE" . "<br>";
			// echo ( napravi_tabelu( zaokruzi_koeficijente_za_prikaz ($matrica) ) );
			// ako je element glavne dijagonale NULA ONDA MORA DA SE ZAMENI RED sa nekim drugim redom, koji je ispod i nije nula
			$matrica = zamena_redova_gauss($matrica, $r);
			// echo "POSLE ZAMENE" . "<br>";
			// echo ( napravi_tabelu( zaokruzi_koeficijente_za_prikaz ($matrica) ) );
			// exit();
		}

		$matrica = gl_dijagonala_sve_jedinice($matrica, $r);
		for($ispod = $r + 1; $ispod < count($matrica); $ispod++)
		{
			// samo red treba da postoji
			if( isset($matrica[$ispod]) AND $matrica[$ispod][$r] != 0)
			{

				// donji element podeljen sa gl dijagonalom daje faktor nuliranja
				$x = $matrica[$ispod][$r] / $matrica[$r][$r];
				
				$matrica = mnozenje_redova($matrica, $x, $r, $ispod);
			
				// if( da_li_je_gl_d_nula($matrica) )
				// {
				// 	echo "GLAVNA DIJAGONALA IMA NULU U SEBI, gaus, NEMA STA DALJE DA SE RADI... " . "<br>";
				// 	echo ( napravi_tabelu( zaokruzi_koeficijente_za_prikaz ($matrica) ) );

				// 	exit();
				// }
			}
		}
		
	}

	return $matrica;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

function jordan_nuliranje_matrice($matrica)
{
	for($r = 0; $r < count($matrica) ; $r++)
	{
		if($matrica[$r][$r] == 0)
		{
			// echo "PRE ZAMENE" . "<br>";
			// echo ( napravi_tabelu( zaokruzi_koeficijente_za_prikaz ($matrica) ) );
			// ako je element glavne dijagonale NULA ONDA MORA DA SE ZAMENI RED sa nekim drugim redom, koji je ispod i nije nula
			$matrica = zamena_redova_jordan($matrica, $r);
			// echo "POSLE ZAMENE" . "<br>";
			// echo ( napravi_tabelu( zaokruzi_koeficijente_za_prikaz ($matrica) ) );
			// exit();
		}

		$matrica = gl_dijagonala_sve_jedinice($matrica, $r);
		for($iznad = $r - 1; $iznad > -1; $iznad--)
		{
			// samo red treba da postoji
			if( isset($matrica[$iznad]) AND $matrica[$iznad][$r] != 0)
			{
				// gornji element podeljen sa gl dijagonalom daje faktor nuliranja
				$x = $matrica[$iznad][$r] / $matrica[$r][$r];

				$matrica = mnozenje_redova($matrica, $x, $r, $iznad);

				// if( da_li_je_gl_d_nula($matrica) )
				// {
				// 	echo "GLAVNA DIJAGONALA IMA NULU U SEBI, jordan, NEMA STA DALJE DA SE RADI... " . "<br>";
				// 	echo ( napravi_tabelu( zaokruzi_koeficijente_za_prikaz ($matrica) ) );

				// 	exit();
				// }	
			}
		}
		
	}
	return $matrica;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

function mnozenje_redova($matrica, $x, $r, $ispod)
{
	// za svaku kolonu u kojoj postoji dijagonala
	for($k = 0; $k < count($matrica)+1; $k++)
	{
		$matrica[$ispod][$k] = $matrica[$ispod][$k] - $matrica[$r][$k] * $x; 
		

	}
	return $matrica;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

// stavi sve elemente glavne dijagonale na 1
function gl_dijagonala_sve_jedinice($matrica)
{
	// echo ( napravi_tabelu( $matrica ) );
	/*	
	if($matrica[$r][$r] != 1)
	{
		$x = $matrica[$r][$r];
		// print_r($matrica[$r][$r]); echo ", ";
		// exit();
		
		for($k = 0; $k < count($matrica) + 1; $k++)
		{
			if($matrica[$r][$k] != 0)
			{
				$matrica[$r][$k] = $matrica[$r][$k] / $x;
			}
		}
	}*/
	
	
	for($r = 0; $r < count($matrica); $r++)
	{
		if($matrica[$r][$r] != 1)
		{
			$x = $matrica[$r][$r];
			// print_r($matrica[$r][$r]); echo ", ";
			// exit();

			// podela citavog reda matrice sa vrednoscu njegove glavne idjagonale
			for($k = 0; $k < count($matrica) + 1; $k++)
			{
				if($matrica[$r][$k] != 0)
				{
					$matrica[$r][$k] = $matrica[$r][$k] / $x;
				}
			}
		}
	}
	
	return $matrica;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

function formiraj_string_formula_sa_intervalima($niz_koeficijenata_sa_vrednostima)
{
	$formule = array();
	for($i = 1; $i <= count($niz_koeficijenata_sa_vrednostima) / 3; $i++)
	{
		$koef_a = $niz_koeficijenata_sa_vrednostima["a{$i}"];
		$koef_b = $niz_koeficijenata_sa_vrednostima["b{$i}"];
		$koef_c = $niz_koeficijenata_sa_vrednostima["c{$i}"];

		$formule[$i] = "P(x) = x * x * ( {$koef_a} ) 	+	 x *  ( {$koef_b} ) 	+  	( {$koef_c} )";
	}
	return $formule;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

// funkcija formira hash tabelu koeficijent=>vrednost
function niz_koeficijenata_sa_vrednostima($matrica)
{
	$resenje = array();
	$dim = count($matrica);

	for($i = 0, $indeks_cvora = 1; $i < $dim; $i = $i + 3, $indeks_cvora++)
	{
		$resenje["a{$indeks_cvora}"] = $matrica [$i    ] [$dim];
		$resenje["b{$indeks_cvora}"] = $matrica [$i + 1] [$dim];
		$resenje["c{$indeks_cvora}"] = $matrica [$i + 2] [$dim];
	}
	return $resenje;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

function u_kom_intervalu_je_input($niz_intervali, $x)
{
	for($i = 0; $i < count($niz_intervali); $i++ )
	{
		if( $x >= $niz_intervali[$i][0] AND $x <= $niz_intervali[$i][1] )
		{
			return $i;
		}
	}
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

function abc_grupe($niz_koeficijenata_sa_vrednostima)
{
	$niz_koeficijenata_sa_vrednostima  = array_values($niz_koeficijenata_sa_vrednostima);

	$rez = array();
	for($i = 0, $kriva = 1; $i < count($niz_koeficijenata_sa_vrednostima); $i = $i + 3, $kriva++)
	{
		$rez[$kriva] = array();
		array_push($rez[$kriva], $niz_koeficijenata_sa_vrednostima[$i    ]);
		array_push($rez[$kriva], $niz_koeficijenata_sa_vrednostima[$i + 1]);
		array_push($rez[$kriva], $niz_koeficijenata_sa_vrednostima[$i + 2]);
	}
	return $rez;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

function da_li_je_gl_d_nula($matrica)
{
	for($r = 0; $r < count($matrica); $r++)
	{
		if($matrica[$r][$r] == 0)
		{
			return true;
		}
	}
	return false;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

function zaokruzi_koeficijente_za_prikaz ($matrica)
{
	for($r = 0; $r < count($matrica); $r++)
	{
		for($k = 0; $k < count($matrica) + 1; $k++)
		{
			$matrica[$r][$k] = round($matrica[$r][$k], 1);
		}
	}
	return $matrica;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

function zamena_redova_gauss($matrica, $r)
{
	// pronadji element ispod ELEMENTA GLAVNE DIJAGONALE koji nije nula
	for($red_ispod = $r + 1; $red_ispod < count($matrica); $red_ispod++ )
	{
		if ( isset($matrica[$red_ispod]) AND $matrica[$red_ispod] != 0) 
		{
			$temp1 = $matrica[$r];
			$temp2 = $matrica[$red_ispod];

			$matrica[$red_ispod] = $temp1;
			$matrica[$r] = $temp2;

			return $matrica;
		}
	}
	return $matrica;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------
function zamena_redova_jordan($matrica, $r)
{
	// pronadji element ispod ELEMENTA GLAVNE DIJAGONALE koji nije nula
	for($red_iznad = $r - 1; $red_iznad < - 1; $red_iznad-- )
	{
		if ( isset($matrica[$red_iznad]) AND $matrica[$red_iznad] != 0) 
		{
			$temp1 = $matrica[$r];
			$temp2 = $matrica[$red_iznad];

			$matrica[$red_iznad] = $temp1;
			$matrica[$r] = $temp2;

			return $matrica;
		}
	}
	return $matrica;
}



// -----------------------------------------------------------------------------------------------------------------------------------------------------
?>