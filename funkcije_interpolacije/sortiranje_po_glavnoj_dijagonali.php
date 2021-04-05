<?php

// fja sortira matricu tako da glavna dijagonala nije nula 
function sort_gl_dijagonala($matrica)
{
	// u slucaju da je matrica nekim cudom zapravo ne nula na glavnoj dijagonali
	if(!da_li_ima_nula_u_gl_dijagonali($matrica))
	{
		return $matrica;
	}

	// dodat string kao identifikator promenljive za svoj red, kao sto su komentari gore u primeru $matrica ;
	// broj cvorova interpolacije = broj redova podeljen sa 3, mada ovaj broj mogu dobiti kad uradim kod za instanciranje matrice
	$broj_cvorova = count($matrica) / 3;
	$combo = promenljive_sistema_jednacina($matrica, $broj_cvorova);
	$matrica = $combo[0];
	$niz_svih_promenljivih  = $combo[1];

	// broj redova matrice
	$max_red    = count($matrica);
	// broj kolona matrice
	$max_kolona = count($matrica[0]);
	$sortirane_promenljive = array();

	$glavna_dijagonala = glavna_dijagonala($max_red);

	$konacna_matrica = array();
	
	$niz_kombinacija = niz_kombinacija($matrica, $glavna_dijagonala);

	// loop za sve redove,unutar njega mora biti loop za sve njegove (TOG REDA) elemente
	for($red = 0; $red < $max_red; $red++)
	{
		// foreach jer ce se unsetovati elementi u ovom loopu
		// $kljuc_promenljve  int
		// $naziv_promenljive str
		// za svaku promenljivu probaj da formiras jednu kombinaciju tako da ako je formira, vrati resenje
		foreach ($niz_kombinacija[$red] as $kljuc_promenljve => $naziv_promenljive) 
		{
			$pokusaj_kombinacije = probaj_jednu_kombinaciju($red, $niz_kombinacija, $kljuc_promenljve, $matrica);

			if( provera_pokusaja_kombinacije($pokusaj_kombinacije, $matrica, $niz_svih_promenljivih) )
			{
				$konacna_matrica = poredja_konacnu_matricu($pokusaj_kombinacije, $matrica);
				
				ksort($konacna_matrica);
				if (!da_li_ima_nula_u_gl_dijagonali($konacna_matrica)) 
				{
					// print_r($konacna_matrica);
					return $konacna_matrica;
				}
				
			}
		}

	}
	echo ": (((((((((((((((((((((((((((";
	exit("Дошло је до фаталне грешке!");
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
	// var_dump($elementi_glavne_dijagonale);
	return $elementi_glavne_dijagonale;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

// test za proveru da li: je svaka promenljiva upotrebljena samo jednom, to ujedno znaci da je svaki element glavne dijagonale popunjen ne nulom
function provera_pokusaja_kombinacije($pokusaj_kombinacije, $matrica, $niz_svih_promenljivih)
{
	// loop za proveru da li je svaka promenljiva upotrebljena
	
	foreach ($niz_svih_promenljivih as $key => $value) 
	{
		// ako nije upotrebljena
		if( !in_array($value, $pokusaj_kombinacije) )
		{
			return FALSE;
		}
	}

	// pokusaj kombinacije i originalna matrica moraju biti istih dimenzija
	if(count($matrica) != count($pokusaj_kombinacije))
	{
		return FALSE;
	}
	// uspesna provera, ova kombinacija (pokusaj_komvinacijke) POPUNJAVA GLAVNU DIJAGONALU NE NULA VREDNOSTIMA!!!!!!!!!
	return TRUE;
}
// -----------------------------------------------------------------------------------------------------------------------------------------------------

function poredja_konacnu_matricu($pokusaj_kombinacije, $matrica)
{
	$konacna_matrica = array();
	ksort($pokusaj_kombinacije);
	$n = count($matrica) + 1;
	for($r_k = 0; $r_k < count($pokusaj_kombinacije); $r_k++)
	{
		foreach ($matrica as $key => $value) 
		{
			if($pokusaj_kombinacije[$r_k] == $matrica[$key][$n])
			{
				$konacna_matrica[$r_k] = $matrica[$key];
				unset($matrica[$key]);
				break;
			}
		}	
	}
	
	// var_dump($konacna_matrica);
	// echo "<br>";
	return $konacna_matrica;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

function probaj_jednu_kombinaciju($red, $niz_kombinacija, $kljuc_promenljve, $matrica)
{
	$pokusaj_kombinacije = array();
	// var_dump($kljuc_promenljve);
	$pokusaj_kombinacije[$red] = $niz_kombinacija[$red][$kljuc_promenljve];
	// echo "Pokusaj kombinacije, tj prva promenljiva stavljena u niz"
	// var_dump($pokusaj_kombinacije);
	$niz_kombinacija = ukloni_fiksiranu_promenljivu($niz_kombinacija, $niz_kombinacija[$red][$kljuc_promenljve]);
	// u ovoom moemntu niz kombinacija ima uklonjenu jednu promenljivu jer je postavljena u pokusaj kombinacije na odgovarajuci red

	// postavlja se ceo podniz na prazan
	$niz_kombinacija[$red] = array();
	// print_r($niz_kombinacija);


	
	// treba da radi obaj blok dok god nusu jednaki brojevi elemenata 		N E
	// while(count($niz_kombinacija) != count($pokusaj_kombinacije))		N E

	for($probaj = 0; $probaj < count($matrica); $probaj++)
	{
		// pokusaj kljuc treba da dobijem tako sto ce pronaci koji red u niz_komb ima najmanje elemenata
		$pokusaj_kljuc = red_sa_najmanje_dozvoljenih_promenljivih($niz_kombinacija);
		
		if( !isset($pokusaj_kombinacije[$pokusaj_kljuc]) AND !empty($niz_kombinacija[$pokusaj_kljuc]) )
		{
			reset($niz_kombinacija[$pokusaj_kljuc]);
			$promenljiva_pokusaj = current($niz_kombinacija[$pokusaj_kljuc]);
			// var_dump($promenljiva_pokusaj);
			$pokusaj_kombinacije[$pokusaj_kljuc] = $promenljiva_pokusaj;
			$niz_kombinacija = ukloni_fiksiranu_promenljivu($niz_kombinacija, $promenljiva_pokusaj);
			$niz_kombinacija[$pokusaj_kljuc] = array();
		}
	}
	reset($pokusaj_kombinacije);
	// var_dump($pokusaj_kombinacije);
	return $pokusaj_kombinacije;
}
// -----------------------------------------------------------------------------------------------------------------------------------------------------

function red_sa_najmanje_dozvoljenih_promenljivih($niz_kombinacija)
{
	// var_dump($niz_kombinacija);
	$temp = array();
	for ($i=0; $i < count($niz_kombinacija); $i++) 
	{ 
		if(!empty($niz_kombinacija[$i]))
		{
			$temp[$i] = count($niz_kombinacija[$i]);
		}
	}
	if (count($temp) ) {
		$min_red = min($temp);
		return array_search($min_red, $temp);
	}
	return false;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------
function da_li_ima_nula_u_gl_dijagonali($konacna_matrica)
{
	for($r = 0; $r < count($konacna_matrica); $r++)
	{
		if($konacna_matrica[$r][$r] == 0)
		{
			return TRUE;
		}
	}
	// NEMA NULE U SEBI
	return FALSE;
}
// -----------------------------------------------------------------------------------------------------------------------------------------------------


// -----------------------------------------------------------------------------------------------------------------------------------------------------
// funkcija formira niz promenljivih(ai, bi, ci)
// u kljucevima niz-a stoje nizovi svih mogucih promenljivih

function niz_kombinacija($matrica, $glavna_dijagonala)
{
	// var_dump($matrica);
	$dimenzija_matrice = count($matrica);
	$niz_kombinacija = instanciranje_niza_komb($dimenzija_matrice);
	for($r = 0; $r < $dimenzija_matrice; $r++)
	{
		// if(in_array($r, $glavna_dijagonala))
		// {
			for($k = 0; $k < $dimenzija_matrice; $k++)
			{
				if($matrica[$r][$k] != 0)
				{
					array_push($niz_kombinacija[$k], $matrica[$r][$dimenzija_matrice + 1]);
				}
			}
		// } 
	}
	return $niz_kombinacija;
}
// -----------------------------------------------------------------------------------------------------------------------------------------------------

function instanciranje_niza_komb($dim)
{
	$dimenzija_matrice = array();
	for($i = 0; $i < $dim; $i++)
	{
		$dimenzija_matrice[$i] = array();
	}
	return $dimenzija_matrice;
}
// -----------------------------------------------------------------------------------------------------------------------------------------------------
// funkcija koja uklanja ime promenljive iz svih podnizova nakon sto se fiksira u sorted
function ukloni_fiksiranu_promenljivu($niz_kombinacija, $promenljiva)
{
	for($i = 0; $i < count($niz_kombinacija); $i++)
	{
		if(in_array($promenljiva, $niz_kombinacija[$i]))
		{
			$kljuc_promenljve = array_search($promenljiva, $niz_kombinacija[$i]);
			unset($niz_kombinacija[$i][$kljuc_promenljve]);
		}
	}
	return $niz_kombinacija;
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------

// promenljive sistema jednacina
function promenljive_sistema_jednacina($matrica, $broj_cvorova)
{
	$niz_svih_promenljivih = array();
	$i = 1;
	for($r = 0; $r < count($matrica); $r++)
	{
		// za svaki cvor trebaju 3 promenljive
		
		$prva  = "a{$i}";
		array_push($matrica[$r], $prva);
		$niz_svih_promenljivih[] = $prva;

		$druga = "b{$i}";
		array_push($matrica[++$r], $druga);
		$niz_svih_promenljivih[] = $druga;

		$treca = "c{$i}";
		array_push($matrica[++$r], $treca);
		$niz_svih_promenljivih[] = $treca;

		$i++;
	}
	return array($matrica, $niz_svih_promenljivih);
}

// -----------------------------------------------------------------------------------------------------------------------------------------------------


?>