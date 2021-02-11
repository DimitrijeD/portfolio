<?php

class Test_kvalitet
{

	public $osmosmerka_niz,
		   $put_za_pretragu,
		   $niz_pretrage;

	public function __construct($osmosmerka_niz, $niz_pretrage, $put_za_pretragu)
	{
		$this->osmosmerka_niz = $osmosmerka_niz;
	    $this->niz_pretrage = $niz_pretrage;
        $this->put_za_pretragu = $put_za_pretragu;
	}

	public function kvaliteti_reci_pretrage()
	{
		
		// loop za svaku rec
		for($kljuc_rec = 0; $kljuc_rec < count($this->niz_pretrage); $kljuc_rec++)
		{
			// svaka rec ima svoj kvalitet, restartovanje vrednosti
			$kvalitet = 0; 
			$ukupan_broj_istih_sa_susedom = 0;
			$ukupan_broj_suglasnika_sa_susedom = 0;

			// loop za svako slovo reci, u istoj petlji mora da se uveceva i polje puta - $this->put_za_pretragu[$slovo] je polje 
			$rec = $this->niz_pretrage[$kljuc_rec]['rec'];

			// loop za svako slovo reci, u istoj petlji mora da se uveceva i polje puta - $this->put_za_pretragu[$ciljano_polje] je polje 
			// $slovo JE KLJUC SLOVA VEC BROJ SLOVA U TOJ RECI PODELJENO SA 2 jer je cirilcia dvobajtnog tipa kodiranja, ISPOD JE PRAVA VREDNOST SLOVA, TJ SPOJENI BAJTOVI 
			for($slovo = 0, $ciljano_polje = 0; $slovo < mb_strlen($rec, 'Windows-1251'); $slovo++, $ciljano_polje++ )
			{
				$slovo_sp_bajtovi = $rec[$slovo].$rec[++$slovo];

				// susedi tog slova, prolazi kroz svih 9, ali ne radi nista kad je 0,0 !
				for($red = -1; $red <= 1; $red++)
				{
					for($kolona = -1; $kolona <= 1; $kolona++)
					{
						// da li to polje uopste postoji ( kad su coskovi u pitanju)
						if(isset($this->osmosmerka_niz[$this->put_za_pretragu[$ciljano_polje][0] + $red] [$this->put_za_pretragu[$ciljano_polje][1] + $kolona]) ) 
						{
							// red i kolona nisu nula jer je to srednje polje kvadrata
							if( !($red == 0 AND $kolona == 0) ) 
							{
								$sused_red    = $this->put_za_pretragu[$ciljano_polje][0] + $red; 
								$sused_kolona = $this->put_za_pretragu[$ciljano_polje][1] + $kolona; 
								$sused_polje = array ($sused_red, $sused_kolona);

								// slovo u susednom polju
								$posmatrano_susedno_polje = $this->osmosmerka_niz[$sused_red][$sused_kolona]; 

								if( $posmatrano_susedno_polje === $slovo_sp_bajtovi )
								{
									$ukupan_broj_istih_sa_susedom = $ukupan_broj_istih_sa_susedom + 1;
									
								} elseif( in_array($slovo_sp_bajtovi, $GLOBALS['suglasnici']) AND in_array($posmatrano_susedno_polje, $GLOBALS['suglasnici']) )
								{ // za slucaj gde je i slovo i sused neki od suglasnika
									$ukupan_broj_suglasnika_sa_susedom = $ukupan_broj_suglasnika_sa_susedom + 1;
								}															
							}							
						}
					}
				}
			}

			$kvalitet = 3 * $ukupan_broj_istih_sa_susedom + 0.5 * $ukupan_broj_suglasnika_sa_susedom;

			// unos kvaliteta u niz slova
			$this->niz_pretrage[$kljuc_rec]['kvalitet'] = $kvalitet;
		}

		$najmanji_kvalitet = $this->sortiranje_niza($this->niz_pretrage, 'kvalitet', TRUE);
		
		return $najmanji_kvalitet; 
	}

	public function sortiranje_niza($niz = array(), $uslov, $samo_jednu_rec = FALSE)
	{
		// print_r($niz);
		if($niz == NULL)
		{
			return array(); // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		}
		// $niz = json_decode(json_encode($niz), true);
		// print_r($niz);
		$niz_vrednosti_samo_uslova = array();

		foreach ($niz as $kljuc => $vrednost) {
			$niz_vrednosti_samo_uslova[] = $vrednost[$uslov];
		}

		// print_r($niz_vrednosti_samo_uslova);
		asort($niz_vrednosti_samo_uslova);
		// echo "</br>";
		// print_r($niz_vrednosti_samo_uslova);
		foreach ($niz_vrednosti_samo_uslova as $kljuc => $vrednost) {
			$konacni_niz[] = $niz[$kljuc];
		}

		if($samo_jednu_rec){
			return $konacni_niz[0];
		} else {
			return $konacni_niz;
		}
	}


}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------- PODACI ZA TESTIRANJE RADA METODE --------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------


// bez samoglasnika i slova R
$GLOBALS['suglasnici'] = array("Б", "В", "Г", "Д", "Ђ", "Ж", "З", "Ј", "К", "Л", "Љ", "М", "Н", "Њ", "П", "С", "Т", "Ћ", "Ф", "Х", "Ц", "Ч", "Џ", "Ш");

// SLOVA KOJA SE UNESU U OVAJ NIZ MORAJU BITI VELIKA CIRILICNA SLOVA
$osmosmerka_niz = array (
		    		array("_", "_", "_", "_"),
		    		array("К", "К", "Т", "У"),
		    		array("_", "_", "_", "_"), // test za unos u ovaj red (2,)
		    		array("Ј", "К", "Т", "Т"),
		    		array("_", "Г", "_", "Т")
        );							 //

// Reci u nizu ne moraju biti smislene , ocito, tako da i neka random slova rade isto kao i da su reci smislene (ispravne)
$niz_pretrage = array( array('rec'=> "ТТНУ"), array('rec'=> "СТЗУ"), array('rec'=> "ГТМУ") );

// AKO MENJATE PUT, POSTUJTE ISPRAVNO, JEDNOSMERNO KRETANJE KROZ NIZ, DAKLE: za neko polje, iyvrsite iste operacije sabiranja ili oduzimanja reda i kolone, tiem se postize jednosmerno "hodanje" po dvodimenzionalnom nizy, npr: za smer dole od polja (0, 1), samo se uvecava red, dok kolona ostaje ista time se dobije put:
//												 array( array(0, 1), 
//		        	                                    array(0, 2), 
//		        	                                    array(0, 3), 
//		        	                                    array(0, 4)   );
$put_za_pretragu = array(array(0, 3), 
		        	     array(1, 2), 
		        	     array(2, 1), 
		        	     array(3, 0)   );

$test_obj = new Test_kvalitet($osmosmerka_niz, $niz_pretrage, $put_za_pretragu);

// rezultat je gore navedeni niz pretrage sa dodatom vrednoscu kvaliteta za svaku rec
print_r($test_obj->kvaliteti_reci_pretrage());


?>