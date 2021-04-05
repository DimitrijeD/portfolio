<?php

/*
Ideja je bila da metodom svi_putevi() dobijem niz u kojem stoje svi moguci putevi za $red_velicina_osmosmerke * $kolona_velicina_osmosmerke,
kako bi se taj niz upisao u posebnu tabelu tako da svaki put kad korisnik zahteva osmosmerku, ova metoda ne mora da se poziva stalno kad god se zahteva osmosmerka R*K velicine, vec samo da iscita njene puteve iz baze.
Pokusati ponovo posle!!!!!!! Jer nema nikakvog smisla da se stalno, za svaku novu osmosmerku poziva ova metoda, kad  svaku R*K osmosmerku vaze isti putevi.
Isto tako, ako velicine reda i kolone zamene mesta (npr. 3*5 <=> 5*3), ne mora da se formira novi niz sa putevima, vec se samo u pretrazivacu rotira osmosmerka (za 90 stepeni u smeru kazaljke na satu). 
*/

class Osmosmerka_templejt 
{
	public $red_velicina_osmosmerke,
		   $kolona_velicina_osmosmerke,
		   $max_duzina_reci;
	// Nek je najduza rec duzine 12 karaktera, za sad

// ----------------------------------------------------------------------------------------------------------------------------------
	public function __construct($red_velicina_osmosmerke, $kolona_velicina_osmosmerke, $max_duzina_reci, $preuzima_puteve_iz_fajla, $asim_polja = null)
	{
	    $this->red_velicina_osmosmerke = $red_velicina_osmosmerke;
	    $this->kolona_velicina_osmosmerke = $kolona_velicina_osmosmerke;
	    $this->osmosmerka_niz = array();
	    $this->niz_svih_puteva = array();
	    $this->max_duzina_reci = $max_duzina_reci; //12

	    $this->asim_polja = $asim_polja;
	    // var_dump($this->asim_polja);
	    if($this->asim_polja)
	    {
	    	$this->is_asm = true;
	    	$this->br_asm_polja = count($this->asim_polja);
	    	$this->is_normal = false;
	    } else {
	    	$this->is_asm = false;
	    	$this->is_normal = true;
	    }

	    if($preuzima_puteve_iz_fajla)
	    {
	    	$this->preuzima_puteve_iz_fajla = $preuzima_puteve_iz_fajla; 
	    } else {
	    	$this->preuzima_puteve_iz_fajla = FALSE;
	    }
	}
// ----------------------------------------------------------------------------------------------------------------------------------
	public function vrati_red()	{	return $this->red_velicina_osmosmerke;	}
// ----------------------------------------------------------------------------------------------------------------------------------
	public function vrati_kolona() {	return $this->kolona_velicina_osmosmerke;	}
// ----------------------------------------------------------------------------------------------------------------------------------
	// nps - niz_svih_puteva
	// u fajlovima, podatak se naziva: niz_svih_puteva_za_fajl
	public function preuzmi_podatak_nsp_iz_fajla()
	{
		if( $this->preuzima_puteve_iz_fajla )
		{
			$naziv_fajla = $this->red_velicina_osmosmerke . "x" . $this->kolona_velicina_osmosmerke . ".php";
			if( file_exists('templejti_osmosmerke/' . $naziv_fajla) )
			{
				require_once 'templejti_osmosmerke/' . $naziv_fajla;
				$this->niz_svih_puteva = $niz_svih_puteva_za_fajl;

				$br_puteva_klasa = new Testiranje_formule_broja_puteva_u_osm($this->red_velicina_osmosmerke, $this->kolona_velicina_osmosmerke);
				$br_puteva_rez_k = $br_puteva_klasa->izracunaj_broj_puteva();
				$this->broj_puteva = $br_puteva_rez_k;

				return $this->prioritet_duzine_puta($this->niz_svih_puteva);
			}
		} else {
			// znaci da ce praviti novi put ako je u konstruktoru FALSE, ovako radi kod za sad jer moram da proverim prvo da li biblioteka ubrzava rad koda
			// jer ako ne, onda imam 40GB useless fajlova
			return $this->svi_putevi();
		}
	}
// ----------------------------------------------------------------------------------------------------------------------------------
	public function formiranje_prazne_osmosmerke()
	{
		// $osmosmerka_niz popunjena "_"
	    for ($r = 1; $r <= $this->red_velicina_osmosmerke; $r++)
	    {
	    	for ($k = 1; $k <= $this->kolona_velicina_osmosmerke; $k++) 
	    	{
	    		$this->osmosmerka_niz[$r][$k] = "_";
	    	}
	    } 
	    return $this->osmosmerka_niz;
	}
// ----------------------------------------------------------------------------------------------------------------------------------
	 /*
	 Metoda za dobijanje najduze reci koja moze da stane u osmosmerku, 	tako da ako se generise osmosmerka koja ima vise od 12 polja u bilo kom smeru. Najduzi moguc put koji se unosi u niz_svih_puteva ce da bude maksimalno 12 jer najduze reci u tabeli reci su duzine 12 karaktera
	 */
	public function najduza_moguca_rec()
	{
		return min($this->max_duzina_reci, max($this->red_velicina_osmosmerke, $this->kolona_velicina_osmosmerke));
	}
// ----------------------------------------------------------------------------------------------------------------------------------

	public function svi_putevi()
	{
		$put = array();
		$polje = array();

	    // popunjavanje $niz_svih_puteva
	    for ($r = 1; $r <= $this->red_velicina_osmosmerke; $r++)
	    {
	    	for ($k = 1; $k <= $this->kolona_velicina_osmosmerke; $k++)
	    	{
	    		
				for ($sve_moguce_duzine_reci = 3; $sve_moguce_duzine_reci <= $this->max_duzina_reci; $sve_moguce_duzine_reci++) 
				{ 
					//smer DESNO
					//provera - da li rec sa tom duzinom ($sve_moguce_duzine_reci) moze da stane 
					if ($k + $sve_moguce_duzine_reci - 1 <= $this->kolona_velicina_osmosmerke)
					{
						// Upisivanje indeksa polja (mnozina) onoliko puta koliko je dugacka rec
						for ($k_polje = $k; $k_polje - $k + 1 <= $sve_moguce_duzine_reci; $k_polje++)
						{
							$polje = array ($r, $k_polje);
							array_push($put, $polje); 
							if($this->is_asm)
							{
								// proveri da li je to polje jedno od deaktiviranih
								$save_or_skip = $this->da_li_je_polje_jedno_od_deaktiviranih($polje);
								if($save_or_skip){
									break;
								}
							}
						} 
						// array_push($put, "DESNO");
						if($this->is_asm AND $save_or_skip === FALSE)
						{
							// polje nije jedno od deaktiviranih, unesi ga
							array_push($this->niz_svih_puteva, $put);
							
						}
						if($this->is_normal){	
							array_push($this->niz_svih_puteva, $put);
						}
						// "brisanje" sadrzaja niza put;     jer array_push samo unosi drugi argument na kraj niza i time bi mi unosio sve prethodno unete vrednosti puteva i polja u niz_svih_puteva. 
						$put = array ();
					}

					//smer DOLE
					if ($r + $sve_moguce_duzine_reci - 1 <= $this->red_velicina_osmosmerke)
					{
						for ($r_polje = $r; $r_polje - $r + 1 <= $sve_moguce_duzine_reci; $r_polje++)
						{
							$polje = array ($r_polje, $k);
							array_push($put, $polje); 
							if($this->is_asm)
							{
								// proveri da li je to polje jedno od deaktiviranih
								$save_or_skip = $this->da_li_je_polje_jedno_od_deaktiviranih($polje);
								if($save_or_skip){
									break;
								}
							}
						} 
						// array_push($put, "DESNO");
						if($this->is_asm AND $save_or_skip === FALSE)
						{
							// polje nije jedno od deaktiviranih, unesi ga
							array_push($this->niz_svih_puteva, $put);
							
						}
						if($this->is_normal){	
							array_push($this->niz_svih_puteva, $put);
						}
						$put = array (); 
					}

					//smer LEVO
					if ($k - $sve_moguce_duzine_reci >= 0)
					{                    
						for ($k_polje = $k; $k - $k_polje + 1 <= $sve_moguce_duzine_reci; $k_polje--)
						{
							$polje = array ($r, $k_polje);
							array_push($put, $polje); 
							if($this->is_asm)
							{
								// proveri da li je to polje jedno od deaktiviranih
								$save_or_skip = $this->da_li_je_polje_jedno_od_deaktiviranih($polje);
								if($save_or_skip){
									break;
								}
							}
						} 
						// array_push($put, "DESNO");
						if($this->is_asm AND $save_or_skip === FALSE)
						{
							// polje nije jedno od deaktiviranih, unesi ga
							array_push($this->niz_svih_puteva, $put);
							
						}
						if($this->is_normal){	
							array_push($this->niz_svih_puteva, $put);
						}
						$put = array ();
					}

					//smer GORE
					if ($r - $sve_moguce_duzine_reci >= 0)
					{
						for ($r_polje = $r; $r - $r_polje + 1 <= $sve_moguce_duzine_reci; $r_polje--)
						{
							$polje = array ($r_polje, $k);
							array_push($put, $polje); 
							if($this->is_asm)
							{
								// proveri da li je to polje jedno od deaktiviranih
								$save_or_skip = $this->da_li_je_polje_jedno_od_deaktiviranih($polje);
								if($save_or_skip){
									break;
								}
							}
						} 
						// array_push($put, "DESNO");
						if($this->is_asm AND $save_or_skip === FALSE)
						{
							// polje nije jedno od deaktiviranih, unesi ga
							array_push($this->niz_svih_puteva, $put);
							
						}
						if($this->is_normal){	
							array_push($this->niz_svih_puteva, $put);
						}
						$put = array ();
					}

					// DIJAGONALNI PUTEVI ---------------------------------------------------------------------------------------

					//smer GORE_DESNO
					if ($r - $sve_moguce_duzine_reci >= 0 AND $k + $sve_moguce_duzine_reci - 1 <= $this->kolona_velicina_osmosmerke)
					{
						for ($r_polje = $r, $k_polje = $k, $s = $sve_moguce_duzine_reci; $s >= 1; $r_polje--, $k_polje++, $s--)
						{
							$polje = array ($r_polje, $k_polje);
							array_push($put, $polje); 
							if($this->is_asm)
							{
								// proveri da li je to polje jedno od deaktiviranih
								$save_or_skip = $this->da_li_je_polje_jedno_od_deaktiviranih($polje);
								if($save_or_skip){
									break;
								}
							}
						} 
						// array_push($put, "DESNO");
						if($this->is_asm AND $save_or_skip === FALSE)
						{
							// polje nije jedno od deaktiviranih, unesi ga
							array_push($this->niz_svih_puteva, $put);
							
						}
						if($this->is_normal){	
							array_push($this->niz_svih_puteva, $put);
						}
						$put = array ();
					}

					//smer GORE_LEVO 
					if ($r - $sve_moguce_duzine_reci >= 0 AND $k - $sve_moguce_duzine_reci >= 0)
					{
						for ($r_polje = $r, $k_polje = $k, $s = $sve_moguce_duzine_reci; $s >= 1; $r_polje--, $k_polje--, $s--)
						{
							$polje = array ($r_polje, $k_polje);
							array_push($put, $polje); 
							if($this->is_asm)
							{
								// proveri da li je to polje jedno od deaktiviranih
								$save_or_skip = $this->da_li_je_polje_jedno_od_deaktiviranih($polje);
								if($save_or_skip){
									break;
								}
							}
						} 
						// array_push($put, "DESNO");
						if($this->is_asm AND $save_or_skip === FALSE)
						{
							// polje nije jedno od deaktiviranih, unesi ga
							array_push($this->niz_svih_puteva, $put);
							
						}
						if($this->is_normal){	
							array_push($this->niz_svih_puteva, $put);
						}
						$put = array ();
					}

					//smer DOLE_LEVO
					if ($r + $sve_moguce_duzine_reci - 1 <= $this->red_velicina_osmosmerke AND $k - $sve_moguce_duzine_reci >= 0)
					{
						for ($r_polje = $r, $k_polje = $k, $s = $sve_moguce_duzine_reci; $s >= 1; $r_polje++, $k_polje--, $s--)
						{
							$polje = array ($r_polje, $k_polje);
							array_push($put, $polje); 
							if($this->is_asm)
							{
								// proveri da li je to polje jedno od deaktiviranih
								$save_or_skip = $this->da_li_je_polje_jedno_od_deaktiviranih($polje);
								if($save_or_skip){
									break;
								}
							}
						} 
						// array_push($put, "DESNO");
						if($this->is_asm AND $save_or_skip === FALSE)
						{
							// polje nije jedno od deaktiviranih, unesi ga
							array_push($this->niz_svih_puteva, $put);
							
						}
						if($this->is_normal){	
							array_push($this->niz_svih_puteva, $put);
						}
						$put = array ();	
					}

					//smer DOLE_DESNO
					if ($r + $sve_moguce_duzine_reci - 1 <= $this->red_velicina_osmosmerke AND $k + $sve_moguce_duzine_reci - 1 <= $this->kolona_velicina_osmosmerke)
					{
						for ($r_polje = $r, $k_polje = $k, $s = $sve_moguce_duzine_reci; $s >= 1; $r_polje++, $k_polje++, $s--)
						{
							$polje = array ($r_polje, $k_polje);
							array_push($put, $polje); 
							if($this->is_asm)
							{
								// proveri da li je to polje jedno od deaktiviranih
								$save_or_skip = $this->da_li_je_polje_jedno_od_deaktiviranih($polje);
								if($save_or_skip){
									break;
								}
							}
						} 
						// array_push($put, "DESNO");
						if($this->is_asm AND $save_or_skip === FALSE)
						{
							// polje nije jedno od deaktiviranih, unesi ga
							array_push($this->niz_svih_puteva, $put);
							
						}
						if($this->is_normal){	
							array_push($this->niz_svih_puteva, $put);
						}
						$put = array ();
					}
				}
	    	}
	    }

	    // moze samo da se uzme poslednji element niza + 1 i to je jednako broju puteva
	    $this->broj_puteva = count($this->niz_svih_puteva);

	    // razmesti puteve u nizu
	    shuffle($this->niz_svih_puteva);

	    $this->niz_svih_puteva_sortiran_prior = $this->prioritet_duzine_puta($this->niz_svih_puteva);

	    // echo "<br>" . "ukupan broj puteva je: " . count( $this->niz_svih_puteva_sortiran_prior ) . "<br>";
	    // echo "<br>" . "Niz svih puteva : " . "<br>";
	    // prikaz_duzina_puta($this->niz_svih_puteva);

	    // echo "<br>";

	    // echo "Niz sortiranih puteva : "  . "<br>";
	    // prikaz_duzina_puta($this->niz_svih_puteva_sortiran_prior);

	    // exit();
	    return $this->niz_svih_puteva_sortiran_prior;
	    // return $this->niz_svih_puteva;
  	}
// ----------------------------------------------------------------------------------------------------------------------
  	private function da_li_je_polje_jedno_od_deaktiviranih($polje)
  	{
  		for($i = 0; $i < $this->br_asm_polja; $i++ )
  		{
  			if($polje === $this->asim_polja[$i])
  			{
  				// var_dump($polje);
  				// var_dump($this->asim_polja[$i]);
  				// echo "pronadjeno je asm polje, <br>";
  				return true;
  			}
  		}
  		return false;
  	}
// ----------------------------------------------------------------------------------------------------------------------
  	public function broj_preostalih_polja()
  	{
  		return $this->red_velicina_osmosmerke * $this->kolona_velicina_osmosmerke;
  	}

// ----------------------------------------------------------------------------------------------------------------------
  	public function razdeli_puteve_po_duzini($niz_svih_puteva_primljen)
  	{
  		// u tim praznim nizovima ce biti svi putevi istih duzina, putevi duzine 3 u nizu sa kljucem 3; 4 sa 4 i tako dalje
  		$this->niz_svih_puteva_sortiran_po_velicini = array( 3=>array(),4=>array(),5=>array(),
  											                 6=>array(),7=>array(),8=>array(),
  											                 9=>array(),10=>array(),11=>array(),12=>array());

  		for ($put = 0; $put < $this->broj_puteva; $put++)
  		{
  			switch ( count($niz_svih_puteva_primljen[$put]) ) 
  			{
  				case 3:
  					array_push($this->niz_svih_puteva_sortiran_po_velicini[3], $niz_svih_puteva_primljen[$put]);
  					break;

  				case 4:
  					array_push($this->niz_svih_puteva_sortiran_po_velicini[4], $niz_svih_puteva_primljen[$put]);
  					break;

  				case 5:
  					array_push($this->niz_svih_puteva_sortiran_po_velicini[5], $niz_svih_puteva_primljen[$put]);
  					break;

  				case 6:
  					array_push($this->niz_svih_puteva_sortiran_po_velicini[6], $niz_svih_puteva_primljen[$put]);
  					break;

  				case 7:
  					array_push($this->niz_svih_puteva_sortiran_po_velicini[7], $niz_svih_puteva_primljen[$put]);
  					break;

  				case 8:
  					array_push($this->niz_svih_puteva_sortiran_po_velicini[8], $niz_svih_puteva_primljen[$put]);
  					break;

  				case 9:
  					array_push($this->niz_svih_puteva_sortiran_po_velicini[9], $niz_svih_puteva_primljen[$put]);
  					break;

  				case 10:
  					array_push($this->niz_svih_puteva_sortiran_po_velicini[10], $niz_svih_puteva_primljen[$put]);
  					break;

  				case 11:
  					array_push($this->niz_svih_puteva_sortiran_po_velicini[11], $niz_svih_puteva_primljen[$put]);
  					break;

  				case 12:
  					array_push($this->niz_svih_puteva_sortiran_po_velicini[12], $niz_svih_puteva_primljen[$put]);
  					break;

  				default:
  					echo " GRESKA !!!!!";
  					exit();
  					break;
  			}
  		}

  		// posto sam instancirao prazne nizove, hocu da ih uklonim kako ne bi bilo nepotrebnih problema
  		$this->niz_svih_puteva_sortiran_po_velicini =  $this->uklanjanje_praznog_niza_iz__niz_svih_puteva_sortiran_po_velicini();

  		return $this->niz_svih_puteva_sortiran_po_velicini;
  	}


// ----------------------------------------------------------------------------------------------------------------------
  	// funkcija sortira niz_svih_puteva tako da je sansa da su najduzi putevi na pocetku niza visoka, a mala na kraju niza
  	public function prioritet_duzine_puta($niz_svih_puteva_primljen)
  	{
  		// $this->niz_sortiran_prioritetom = array();
  		$this->max_duzina_reci_trim = $this->najduza_moguca_rec();
  		$this->niz_svih_puteva_sortiran_prior = array();

  		if($this->preuzima_puteve_iz_fajla == FALSE)
  		{
  			$this->razdeli_puteve_po_duzini($niz_svih_puteva_primljen);
  		} else {
  			$this->niz_svih_puteva_sortiran_po_velicini = $niz_svih_puteva_primljen;
  		}
  		
  		// nadji random broj na osnovu kog se meri sansa da se unese niz te duzine u rez
  		$this->zig_zag_random($this->max_duzina_reci_trim);
  		
  		// ranije koriscen podatak za pravljenje biblioteke, kada i ako se budu ponovo pravili fajlovi templejta, ova linija se mora uncomment!!!!!!
  		// $this->niz_svih_puteva_za_fajl = $this->niz_svih_puteva_sortiran_po_velicini;

  		// jedan loop mora uneti put na kraj niza $this->niz_svih_puteva_sortiran_prior
  		for($putevi_br = 0; $putevi_br < $this->broj_puteva; $putevi_br++)
  		{
  			// loop za unos dok god se ne unese jedan put
  			$put_nije_unet = TRUE;
  			do
  			{
	  			// loop za sanse
	  			// sanse_kljuc krenu od najduzeg puta i loop do puteva duzine 3
	  			for ($sanse_kljuc = $this->max_duzina_reci_trim; $sanse_kljuc > 2; $sanse_kljuc--)
	  			{
		  			$rand = rand(1, 100);
		  			// ako je poslednji unet u sortirane najvisi, 
		  			if( count($this->niz_svih_puteva_sortiran_po_velicini[$this->poslednji_element_niza($this->niz_svih_puteva_sortiran_po_velicini)]) == $sanse_kljuc)
		  			{
		  				$rand = $rand + 10;
		  			}
		  			if ( $this->zig_zag_random[$sanse_kljuc] > $rand AND !empty($this->niz_svih_puteva_sortiran_po_velicini[$sanse_kljuc]))
		  			{
		  				// put koji se unosi 
		  				$this->unos_puta_u_prior($sanse_kljuc);
		  				$put_nije_unet = FALSE;
		  				break;
		  			}
		  		}
		  	}while ($put_nije_unet);
  		}
  		return $this->niz_svih_puteva_sortiran_prior;
  	}

// ----------------------------------------------------------------------------------------------------------------------
  	public function uklanjanje_praznog_niza_iz__niz_svih_puteva_sortiran_po_velicini()
  	{
  		for($i = 12; 3 < $i; $i--)
  		{
  			if( empty($this->niz_svih_puteva_sortiran_po_velicini[$i]) )
  			{
  				unset($this->niz_svih_puteva_sortiran_po_velicini[$i]);
  			}
  		}
  		return $this->niz_svih_puteva_sortiran_po_velicini;
  	}
// ----------------------------------------------------------------------------------------------------------------------
  	public function unos_puta_u_prior($temp_duzina_reci)
  	{
  		// end($this->niz_svih_puteva_sortiran_po_velicini [$temp_duzina_reci]); 
		// $key = key($this->niz_svih_puteva_sortiran_po_velicini [$temp_duzina_reci]);
		// reset($this->niz_svih_puteva_sortiran_po_velicini);
  		$put_poslednji = array_pop($this->niz_svih_puteva_sortiran_po_velicini [$temp_duzina_reci]);

  		// $put_poslednji = $this->niz_svih_puteva_sortiran_po_velicini [$temp_duzina_reci] [$key];
  		array_push($this->niz_svih_puteva_sortiran_prior, $put_poslednji );
  		
  		// ne treba return valjda ..
  	}
// ----------------------------------------------------------------------------------------------------------------------
  	// funkcija vraca niz = array(int velicina najduze reci => sansa da se on unese ... do poslednjeg )
  	// za sad radim tako da ti nizovi nisu sortirani, mada to jednom fjom resim i ne kucam gluposti u komentaru
  	public function zig_zag_random()
  	{
  		$pocetna_sansa = 80;
  		$broj_razlicitih_duzina = $this->max_duzina_reci_trim - 2;
  		$this->zig_zag_random = array($this->max_duzina_reci_trim => min($pocetna_sansa + $this->max_duzina_reci_trim, 95)); //
  		
  		// u jednom ciklusu unosim sanse nizova prvog i poslednjeg; prvi+1 i poslednji-1 ...

  		$gore = 3;
		$dole = 1;

  		do
  		{
  			$kljuc_poslednje_unetog = $this->poslednji_element_niza($this->zig_zag_random);
  			$sansa_poslednje_unetog = $this->zig_zag_random[$kljuc_poslednje_unetog];
  			
  			// spustanje
  			$sansa_spustanje = 100 - $sansa_poslednje_unetog + $gore;
  			$this->zig_zag_random[$gore] = $sansa_spustanje;
  			
  			// penjanje
  			if( !isset($this->zig_zag_random[$kljuc_poslednje_unetog - $dole]) )
  			{
  				$sansa_penjanje = $sansa_poslednje_unetog - $sansa_spustanje + ($kljuc_poslednje_unetog - $dole);
  				$this->zig_zag_random[$kljuc_poslednje_unetog - 1] = $sansa_penjanje;
  				$broj_razlicitih_duzina--;
  			} else {
  				return $this->zig_zag_random;
  			}
  			
  			$gore++;
  			$broj_razlicitih_duzina--;

  		} while ($broj_razlicitih_duzina > 1);
  		

  	}
// ----------------------------------------------------------------------------------------------------------------------
  	public function poslednji_element_niza($zig_zag_random)
  	{
  		end($zig_zag_random); 
		$key = key($zig_zag_random);
		return $key;
  	}
// ----------------------------------------------------------------------------------------------------------------------
  	public function niz_svih_puteva_za_fajl()
  	{
  		return $this->niz_svih_puteva_za_fajl;
  	}
}

