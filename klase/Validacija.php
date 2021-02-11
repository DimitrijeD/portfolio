<?php
class Validacija 
{
	private $uspesna_validacija = FALSE, 
			$niz_svih_gresaka = array(), 
			$bp_instanca = NULL;
//-----------------------------------------------------------------------------------------------------------------------------
	public function __construct()
	{
		$this->bp_instanca = Baza_podataka::vrati_instancu(); 
	}
//-----------------------------------------------------------------------------------------------------------------------------
	public function provera_unosa($izvor_unosa, $niz_kriterijuma = array()) 
	{
		foreach ($niz_kriterijuma as $tip_kriterijuma => $pravila)
		{
			foreach ($pravila as $_pravilo => $vrednost_pravila)
			{
				$vrednost_inputa = trim($izvor_unosa[$tip_kriterijuma]); // uklanjanje whitespace oko stringa
				// print_r($vrednost_inputa);
				$tip_kriterijuma = ocisti($tip_kriterijuma);

				// var_dump($vrednost_inputa);
				if($_pravilo === 'obavezno' && empty($vrednost_inputa)) 
				{
					$this->dodaj_gresku("{$tip_kriterijuma} је обавезан податак!");
				} else if(!empty($vrednost_inputa)){

					switch($_pravilo)
					{
						case 'velicina_osmosmerke':
							if($vrednost_inputa < $vrednost_pravila AND is_string($vrednost_inputa) AND !is_int($vrednost_inputa)) 
							{
								$this->dodaj_gresku("{$tip_kriterijuma} најмања дозвољена величина осмосмерке је {$vrednost_pravila} или није унет цео број.");
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
							if($vrednost_inputa != $izvor_unosa[$vrednost_pravila])
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
		// konacna vrednost metode, da li je korisnik uneo sve ispravne podatke, tj. nema gresaka
		// na taj nacin se mogu dodati novi kriterijumi, pod sta se podrazumeva uspesna validacija,
		if(empty($this->niz_svih_gresaka))
		{
			$this->uspesna_validacija = TRUE;
		}
		return $this;
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