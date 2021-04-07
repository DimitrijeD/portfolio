<?php
class Validacija 
{
	private $uspesna_validacija = FALSE, 
			$niz_svih_gresaka = array(), 
			$bp_instanca = NULL;
	public  $niz_reci = NULL;
//-----------------------------------------------------------------------------------------------------------------------------
	public function __construct()
	{
		$this->bp_instanca = Baza_podataka::vrati_instancu(); 
	}
//-----------------------------------------------------------------------------------------------------------------------------
	public function provera_unosa($input, $niz_kriterijuma = array()) 
	{
		foreach ($niz_kriterijuma as $tip_kriterijuma => $pravila)
		{
			foreach ($pravila as $_pravilo => $vrednost_pravila)
			{
				$vrednost_inputa = trim($input[$tip_kriterijuma]); // uklanjanje whitespace oko stringa; string
				// print_r($vrednost_inputa);
				$tip_kriterijuma = ocisti($tip_kriterijuma);
				
				// var_dump($vrednost_inputa);
				if($_pravilo === 'obavezno' AND empty($vrednost_inputa) AND $pravila['obavezno'] == TRUE) 
				{
					$this->dodaj_gresku("{$tip_kriterijuma} је обавезан податак!");
				} else if(!empty($vrednost_inputa)){

					switch($_pravilo)
					{
						case 'min_osmosmerka':
							$vrednost_inputa = (int)$vrednost_inputa; // cast to int
							// var_dump($vrednost_inputa);
							if($vrednost_inputa < $vrednost_pravila) 
							{																	
								$this->dodaj_gresku("Најмања дозвољена величина осмосмерке је {$vrednost_pravila} или није унет цео број.");											
							}
						break;

						case 'max_osmosmerka':
							$vrednost_inputa = (int)$vrednost_inputa; 
							// var_dump($vrednost_inputa);
							if($vrednost_inputa > $vrednost_pravila) 
							{																	
								$this->dodaj_gresku("Највећа дозвољена величина осмосмерке је {$vrednost_pravila} или није унет број.");											
							}
						break;
						
						case 'min':
							if(strlen($vrednost_inputa) < $vrednost_pravila) // ispisuje da rec(za osm) mora biti 6 karaktera
							{
								$this->dodaj_gresku("{$tip_kriterijuma} мора бити најмање {$vrednost_pravila} карактера.");
							}
						break;
						
						case 'max':
							if(strlen($vrednost_inputa) > $vrednost_pravila)
							{
								$this->dodaj_gresku("{$tip_kriterijuma} мора бити највише {$vrednost_pravila} карактера.");
							}
						break;
						
						case 'su_jednaki': 
							if($vrednost_inputa != $input[$vrednost_pravila])
							{
								$this->dodaj_gresku("{$vrednost_pravila} мора бити исти као и {$tip_kriterijuma}"); // sifre moraju biti iste
							}
						break;
						
						case 'jedinstven': 
							$provera_za_jedinstven_podatak = $this->bp_instanca->pronadji($vrednost_pravila, array($tip_kriterijuma, '=', $vrednost_inputa)); 
							// var_dump($provera_za_jedinstven_podatak);
							if ($provera_za_jedinstven_podatak->br_redova()) 
							// ako vrati 1 ili vise, znaci da postoji korisnik sa tim imenom
							{
								$this->dodaj_gresku("Промените {$tip_kriterijuma}, јер већ постоји.");
							}
							// ako je u if-u nula, znaci da je pretraga baze nula,
							// npr da bi se korisnik registrovao, mora imati razlicito korisnicko ime od svih ostalih korisnika, isti princip za unos reci u tabelu reci_osmosmerke
						break;

					}
				}
			}
		}

		// $greske_opc_reci = $this->reci_od_korisnika(); // jedan string za sve greske opcionalnih reci
		
		if(!empty($input['reci_od_korisnika']))
		{
			$this->reci_od_korisnika($vrednost_inputa, $pravila);
		}

		if( isset($input['cvorovi']) )
		{ 
			$this->niz_cvorovi($input, $niz_kriterijuma);			
		}
		// 	$this->reci_od_korisnika($vrednost_inputa, $pravila)

		// } else {
		// 	$this->dodaj_gresku("Мора бити најмање {} чворова!");
		// }

		// konacna vrednost metode, da li je korisnik uneo sve ispravne podatke, tj. nema gresaka
		// na taj nacin se mogu dodati novi kriterijumi, pod sta se podrazumeva uspesna validacija,
		if(empty($this->niz_svih_gresaka))
		{
			$this->uspesna_validacija = TRUE;
		}
		return $this;
	}
//-----------------------------------------------------------------------------------------------------------------------------
	private function reci_od_korisnika($vrednost_inputa, $pravila)
	{
		$greske = '';
		$this->niz_reci = explode(",", $vrednost_inputa);
		foreach ($this->niz_reci as $key => $value) 
		{
			$this->niz_reci[$key] = trim($this->niz_reci[$key]);
			$this->niz_reci[$key] = ocisti($this->niz_reci[$key]);

			$duzina_reci = strlen($this->niz_reci[$key]) / 2;
			if($duzina_reci < 3 OR $duzina_reci > max($pravila['red'], $pravila['kolona']) )
			{
				$greske .= 'Pеч "'. $this->niz_reci[$key] .'" није дозвољене дужине. ';
			}

			if (da_li_je_sav_str_cirilicni($this->niz_reci[$key]) == FALSE AND $pravila['cirilica'] == TRUE) 
			{
				$greske .= 'Унета реч није ћирилична';
			}
			
			/*
			un comment ako se budu pravile latinicne osmosmerke
			if (da_li_je_sav_str_latinicni($this->niz_reci[$key]) AND $pravila['latinica'] == TRUE) 
			{
				$greske .= 'Унета реч није ћирилична';
			}
			*/
		}
		if(!empty($greske)){
			$this->dodaj_gresku($greske);
		}
	}
	//-----------------------------------------------------------------------------------------------------------------------------
	public function vrati_reci_od_korisnika()
	{
		return $this->niz_reci;
	}

	//-----------------------------------------------------------------------------------------------------------------------------
	// formira niz na osnovu stringa inputa za cvorove
	private function niz_cvorovi($input, $niz_kriterijuma)
	{
		$cvorovi = $input['cvorovi'];
		$interpolanti = $input['tacke_x'];
		$cvorovi = ocisti($cvorovi);

		$za_min_max = array();

		$greske ='';
		$rez = array();
		$niz_cvorovi = explode( "/", $cvorovi );

		// validacija ispravno upisanih brojeva, ne sme biti char u cvorovima
		for($i = 0; $i < count($niz_cvorovi); $i++)
		{
			$rez[$i] = explode( ",", $niz_cvorovi[$i] );

			if($this->proveri_string_cvora($rez[$i]))
			{
				$greske .= 'Вредност <strong> / ' . $rez[$i][0] . ',' . $rez[$i][1] . '</strong> / није број!';
			} 
		}

		// provera da li su sve vrednosti cvorova po x osi razlicite
		if($greske)
		{
			// resetuj greske
			$greske = '';

			$niz_x_vrednosti_cvorova = array();
			foreach ($rez as $key => $value) 
			{
				$niz_x_vrednosti_cvorova[] = trim($value[0]);
			}

			// proveri da li se ijedna vrednost x ose cvora pojavljuje vise od jednom
			$greske .= $this->da_li_se_redovi_cvorova_ponavljaju($niz_x_vrednosti_cvorova, $greske);
			if(!empty($greske) )
			{
				$this->dodaj_gresku($greske);
			}

		} else {
			// sto se tice cvorova sve je ok, konacno ih konvertuj u float!
			foreach ($rez as $i => $value) {
				$za_min_max[] = (int)$rez[$i][0];	
            	$rez[$i][0] = (float)$rez[$i][0];
            	$rez[$i][1] = (float)$rez[$i][1];   
			}
		}

		$this->pripremljen_niz_cvorova = $rez;
		$min = min($za_min_max);
		$max = max($za_min_max);
		
		if(!empty($interpolanti))
		{
			$this->sredi_interpolante($interpolanti, $min, $max);
		}

		if(!empty($greske)){
			$this->dodaj_gresku($greske);
		}	
	}
	//-----------------------------------------------------------------------------------------------------------------------------
	// Sredjivanje vrednosti za interpolaciju: 
	// 		1. ukloni duplikate, 
	//		2. dodaj gresku ako je interpolant manji od najmanje vrednosti cvora;
	private function sredi_interpolante($interpolanti, $min, $max)
	{
		$interpolanti = ocisti($interpolanti);
		$greske = '';
		$niz_interpolanata = explode( "/", $interpolanti );
		$za_min_max = array();
		
		foreach ($niz_interpolanata as $i => $string) 
		{
			$niz_interpolanata[$i] = trim($string);
			
			if($string)
			{
				for($poz = 0; $poz < strlen($string); $poz++)
				{
					if (!in_array($string[$poz], $GLOBALS['brojevi_sa_tackom_zarezom'])) 
					{
						$greske .= 'Вредности за интерполацију нису у исправном формату. Постоји грешка у инпуту';
						break;
					}
				}
			}
		}
		if(!$greske)
		{
			foreach ($niz_interpolanata as $i => $string) 
			{
				$za_min_max[] = (float) $niz_interpolanata[$i];
			}
			$min_interpolanata = min($za_min_max);
			$max_interpolanata = max($za_min_max);

			if($min_interpolanata < $min OR $max_interpolanata > $max)
			{
				$greske .= 'Није могуће извршити интерполацију. Интерполант мора бити у скупу [min_x_cvor, max_x_cvor]. За проналажење вредности ван споменутог скупа користите екстраполацију.';
			}
		}

		foreach ($niz_interpolanata as $k => $v) {
			$niz_interpolanata[$i] = (float)$v;
		}

		$this->niz_interpolanata = $niz_interpolanata;

		if(!empty($greske)){
			$this->dodaj_gresku($greske);
		}	

	}
	//-----------------------------------------------------------------------------------------------------------------------------

	// OVA GLUPOST OD PROKLETOG CASTOVANJA PRETVORI BROJ U NULU AKO IMA SLOVA NA POCETKU BROJA AJNSfkjhsdbgksdgnlklfhbd
	private function proveri_string_cvora($x_y_par)
	{
		foreach ($x_y_par as $key => $value) 
		{
			$duzina_stringa_u_cvoru = strlen($value);
			for($i = 0; $i < $duzina_stringa_u_cvoru; $i++)
			{
				if ( !in_array($value[$i], $GLOBALS['brojevi_sa_tackom_zarezom']) ) 
				{
					return true;
				}
			}
			
		}
		return false;
	}
	//-----------------------------------------------------------------------------------------------------------------------------
	private function da_li_se_redovi_cvorova_ponavljaju($novi_niz, $greske)
	{
		foreach ($novi_niz as $prvi_k => $prvi_v) 
		{
			foreach ($novi_niz as $poredi_k => $poredi_v) 
			{
				if($prvi_v === $poredi_v AND $prvi_k != $poredi_k ) //AND $prvi_v != $poredi_v 
				{
					$greske .= 'Вредност <strong> / ' . $prvi_v . '</strong> / се појављује више пута!';
					break;
				}
			}
		}
		return $greske;
	}
	//-----------------------------------------------------------------------------------------------------------------------------
	public function vrati_niz_interpolanata()
	{
		if(isset($this->niz_interpolanata) )
		{
			return $this->niz_interpolanata;
		} else {
			return null;
		}
	}
	//-----------------------------------------------------------------------------------------------------------------------------
	public function vrati_pripremljen_niz_cvorova()
	{
		if(isset($this->pripremljen_niz_cvorova) )
		{
			return $this->pripremljen_niz_cvorova;
		} else {
			return null;
		}
		
	}
//-----------------------------------------------------------------------------------------------------------------------------
	private function dodaj_gresku($greska)
	{
		$this->niz_svih_gresaka[] = $greska; 
	}
//-----------------------------------------------------------------------------------------------------------------------------
	public function sve_greske()
	{
		return $this->niz_svih_gresaka;
	}
//-----------------------------------------------------------------------------------------------------------------------------
	public function validacija_uspela()
	{
		return $this->uspesna_validacija;
	}
//-----------------------------------------------------------------------------------------------------------------------------
}