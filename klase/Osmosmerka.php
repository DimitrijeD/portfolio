<?php

/* Niz svih unetih reci u osmosmerku
koristim global kako bih mogao bilo gde i bilo kad da koristim reci kad mi zatrebaju, mada nema razloga da to ne bude prop klase, ali intuicija radi svoje */

// treba mi njen :	ID       kako bih iz tog niza updatovao kolonu broj upotrebljenih/neuspelih formiranja osmosmerke

$GLOBALS['unete_reci'] = array(); // niz koji sluzi za popunjavanje osmosmerke a da se reci ne ponavljaju
$GLOBALS['unete_reci_sa_putevima'] = array(); // niz koji ce da sluzi za resavanje osm; sve osim resenja (posl rec)

$GLOBALS['suglasnici'] = array("Б", "В", "Г", "Д", "Ђ", "Ж", "З", "Ј", "К", "Л", "Љ", "М", "Н", "Њ", "П", "С", "Т", "Ћ", "Ф", "Х", "Ц", "Ч", "Џ", "Ш");
$GLOBALS['samoglasnici'] = array ("А", "Е", "И", "О", "У", "Р");
// R je medju samoglasnicima jer postoje reci od vise slova u kojima nema samoglasnika npr krst, trst , ima ih dosta

class Osmosmerka 
{
	//iz forme
	public $red_velicina_osmosmerke,
	 	   $kolona_velicina_osmosmerke,

	 	   $osmosmerka_niz = array(),
	 	   $put_za_pretragu = array (),
	 	   $rec_za_pretragu = "",
	 	   $rec_za_unos_u_osmosmerku = "",
	 	   $id_korisnika;

// --------------------------------------------------------------------------------------------------------------------------
	public function __construct($red_velicina_osmosmerke, $kolona_velicina_osmosmerke, $reci_od_korisnika, $id_korisnika)
	{
		$templejt = new Osmosmerka_templejt($red_velicina_osmosmerke, $kolona_velicina_osmosmerke, array(), array(), 12);
	    $this->red_velicina_osmosmerke = $red_velicina_osmosmerke;
	    $this->kolona_velicina_osmosmerke = $kolona_velicina_osmosmerke;

	    $this->reci_od_korisnika = $reci_od_korisnika;
	    $this->osmosmerka_niz = $templejt->formiranje_prazne_osmosmerke(); 

	    $this->niz_svih_puteva = $templejt->svi_putevi();

	    $this->max_duzina_reci = $templejt->najduza_moguca_rec();
	    
	    

	    // kako bi se uneo u tabelu u sluaju da ga nema, tj nema konacno resenje ali se moze resiti 
		//precrtavanjem svih reci u osm 
	    $this->resenje = '/'; 
	    $this->bp_instanca = Baza_podataka::vrati_instancu();
	    $this->id_korisnika = $id_korisnika;

	    $this->brojac_donjih_crta = 0;

	    // koliko reci da pronadje u bazi, default value
	    $this->koliko = 10;

	    //trenutno predstavlja ukupan broj polja u simetricnoj osmosmerci
	    $this->broj_preostalih_polja = $templejt->broj_preostalih_polja();

	    $this->max_broj_polja = $this->broj_preostalih_polja;

	    $this->min_donjih_crta = 4;
	}
// --------------------------------------------------------------------------------------------------------------------------
	public function vrati_niz_svih_puteva(){ return $this->niz_svih_puteva;	}
// --------------------------------------------------------------------------------------------------------------------------
	public function popunjavanje_sa_korisnickim_recima()
	{
		if (!empty($this->reci_od_korisnika[0]) ) 
		{
			for ($rec_k = 0; $rec_k < count($this->reci_od_korisnika) ; $rec_k++) 
			{ 
				for($put_k = 0; $put_k < count($this->niz_svih_puteva); $put_k++)
				{
					if( count($this->niz_svih_puteva[$put_k]) == mb_strlen($this->reci_od_korisnika[$rec_k]) )
					{
						$this->put_za_pretragu = $this->niz_svih_puteva[$put_k];
						if ( $this->rec_moze_na_put($rec_k) )
						{
							$this->razbijanje_reci_na_slova( array('rec'=>$this->reci_od_korisnika[$rec_k]) );
							$this->unos_reci_u_osmosmerku(); 
							$this->uspesan_unos_reci( array('rec'=>$this->reci_od_korisnika[$rec_k]) );	
							$this->trenutan_broj_praznih_polja();

							break;						
						}

					}
				}
			}
		}

		return $this->popunjavanje_osmosmerke();
	}
// --------------------------------------------------------------------------------------------------------------------------
	// f-ja proverava da li korisnicka rec moze da stane u osmosmerku na trenutni put, dakle taj zadatak sto radi sql upit, ovde radi php
	// za razliku od normalnog popunjavanja osmosmerke, ovde znam koju rec unosim, ali ne znam gde je unosim, a mora biti uneta, osim ako 
	// nema vise mesta u osm,
	public function rec_moze_na_put($rec_k)
	{
		$string_od_puta = $this->formiranje_reci_iz_osmosmerke(); // string slova na poljima puta
		// petlja prolazi kroz korisnicku rec i proverava da li je 
		for($slovo = 0, $polje = 0; $slovo < mb_strlen($this->reci_od_korisnika[$rec_k], 'Windows-1251'); $slovo++, $polje++)
		{
			$slovo_sp_bajtovi_k = $this->reci_od_korisnika[$rec_k][$slovo].$this->reci_od_korisnika[$rec_k][++$slovo];
			$slovo_osm = $this->osmosmerka_niz[ $this->put_za_pretragu [$polje] [0] ][$this->put_za_pretragu [$polje] [1] ];
			if( $slovo_sp_bajtovi_k == $slovo_osm OR $slovo_osm == "_")
			{

			} else {
				return false;
			}
		}
		return true;
	}
// --------------------------------------------------------------------------------------------------------------------------
	public function popunjavanje_osmosmerke()
	{
		$broj_puteva = count($this->niz_svih_puteva);
		$this->broj_izvrsenih_upita = 0;

		for($brojac_popunjavanja = 0; $brojac_popunjavanja < $broj_puteva ; $brojac_popunjavanja++)
		{
			if($this->broj_preostalih_polja == 0 OR $this->broj_preostalih_polja < $this->max_duzina_reci )	{
				break;	
			}
			// ako je preostalo manje od 20% praznih polja, unosi bilo sta samo da se popuni do 12
			if($this->broj_preostalih_polja < $this->max_broj_polja * 0.2)
			{
				$this->min_donjih_crta = 1;
			}

			$this->put_za_pretragu = $this->niz_svih_puteva[$brojac_popunjavanja];

			if($this->da_li_rec_ima_donju_crtu( $this->formiranje_reci_iz_osmosmerke() ))
			{
				$this->broj_izvrsenih_upita++;
				if( $this->pretraga_baze() )
				{
					$najkvalitetnija_rec_sa_podacima = $this->kvaliteti_reci_pretrage();
					
					$this->razbijanje_reci_na_slova($najkvalitetnija_rec_sa_podacima);
					// $this->razbijanje_reci_na_slova($this->niz_pretrage[0]);

					$this->unos_reci_u_osmosmerku();
					$this->uspesan_unos_reci($najkvalitetnija_rec_sa_podacima);
					$this->trenutan_broj_praznih_polja();
				}
			}
		}
		
		// radi cudno kada je jedna dimenyija veca od druge npr 10*40 !
		if( $this->broj_preostalih_polja <= $this->max_duzina_reci ) 
		{
			$this->popunjavanje_preostalih_polja_osmosmerke();
		} else {
			// preostalo je vise od 12 nepopunjenih polja, ne moze da popuni preostala polja resenjem
		}

		$this->azuriranje_brojac_uspesnih_unosa();
		$this->ispisivanje_reci_osm();

		$this->konverzija_osmosmerke_u_string();
		$this->unos_osmosmerke_u_bazu();

		echo "<br>" . "broj izvrsenih upita je : " . $this->broj_izvrsenih_upita .  "<br>";
		echo "<br>" . "broj unetih reci je : " . count($GLOBALS['unete_reci']) .  "<br>";
		echo "<br>" . "broj preostalih polja je : " . $this->broj_preostalih_polja .  "<br>";

		return $this->osmosmerka_niz;
	}

// --------------------------------------------------------------------------------------------------------------------------
	//Metoda koja formira rec za pretragu na osnovu odabranog puta iz niza $niz_svih_puteva
	public function formiranje_reci_iz_osmosmerke()
	{
		$this->rec_za_pretragu = "";
		$br_ciklusa = count($this->put_za_pretragu);
		for($i = 0; $i < $br_ciklusa; $i++)
		{
			$this->rec_za_pretragu .= $this->osmosmerka_niz [$this->put_za_pretragu[$i][0]] [$this->put_za_pretragu[$i][1]];
		}
		return $this->rec_za_pretragu;
	}
// --------------------------------------------------------------------------------------------------------------------------
	public function pretraga_baze()
	{
		if ($this->rec_za_pretragu != NULL)
		{
			$broj_karaktera_u_reci = mb_strlen($this->rec_za_pretragu);
			$tabela = "reci_osmosmerke_" . "{$broj_karaktera_u_reci}";

			$this->niz_pretrage = $this->bp_instanca->pronadji($tabela, array ('rec', 'LIKE', $this->rec_za_pretragu), $this->koliko);
			$this->niz_pretrage = $this->bp_instanca->rezultati_bp();

			if($this->niz_pretrage)
			{
				$this->niz_pretrage = da_li_rec_postoji_u_osmosmerci($this->niz_pretrage);
				// $this->niz_pretrage = sortiranje_niza($this->niz_pretrage, 'brojac_uspesnih_unosa');
				return $this->niz_pretrage;
			} else {
				return FALSE;
			}			
		}
	}
// --------------------------------------------------------------------------------------------------------------------------
	public function razbijanje_reci_na_slova($rec_za_unos)
	{
		$this->rec_za_unos_u_osmosmerku = mb_strtoupper($rec_za_unos['rec']); // velika slova reci
		
		if ($this->rec_za_unos_u_osmosmerku != NULL)
		{
			$this->rec_razbijena_na_slova = array();
			for ($i = 0, $k = 0; $i < mb_strlen($this->rec_za_unos_u_osmosmerku, 'Windows-1251'); $i++ ,$k++)
			{
				$this->rec_razbijena_na_slova[$k] = $this->rec_za_unos_u_osmosmerku[$i] . $this->rec_za_unos_u_osmosmerku[++$i];
			}
			return $this->rec_razbijena_na_slova; // niz
		}
	}
// --------------------------------------------------------------------------------------------------------------------------
	public function unos_reci_u_osmosmerku()
	{
		if ($this->rec_razbijena_na_slova != NULL)
		{
			for ($i = 0; $i < count($this->rec_razbijena_na_slova); $i++)
			{												//red   kolona 					  //red  kolona
		    	$this->osmosmerka_niz[ $this->put_za_pretragu [$i] [0] ][$this->put_za_pretragu [$i] [1] ] = $this->rec_razbijena_na_slova[$i];
			}
		}
	}
// --------------------------------------------------------------------------------------------------------------------------
	public function da_li_rec_ima_donju_crtu_striktno($rec = '')
	{
		// brojac koliko donjih crta (_) ima u stringu $rec
		$this->brojac_donjih_crta = 0;

		if($rec)
		{
			for($i = 0; $i < strlen($rec); $i++)
			{
				if($rec[$i] == "_"){
					// echo "karakter je _";
					$this->brojac_donjih_crta++; 	
				} 
			}
		}

		if($this->brojac_donjih_crta <= $this->min_donjih_crta){
			//nijedan bajt nije jednak "_" i ne postoje 4+ vezana suglasnika
			return FALSE;
		} else {
			return TRUE;
		}	
	}
// --------------------------------------------------------------------------------------------------------------------------
	public function da_li_rec_ima_donju_crtu($rec = '')
	{
		// brojac koliko donjih crta (_) ima u stringu $rec

		$this->brojac_donjih_crta = 0;

		$brojac_suglasnika = 0; // resetuj ga na nula

		if($rec)
		{
			for($i = 0; $i < strlen($rec); $i++)
			{
				// echo "<br>" . $i . ". ciklus -";
			
				if($rec[$i] == "_")
				{
					// echo "karakter je _";
					$this->brojac_donjih_crta++; 
					$brojac_suglasnika = 0;
				} elseif (isset($rec[$i + 1]))
				{
					$spojeni = $rec[$i].$rec[$i + 1];
					if(in_array($spojeni, $GLOBALS['suglasnici'])) 
					{ 
						// echo "SLOVO JE SUGLASNIK";
						// brojac_suglasnika - ideja je da ako su u stringu 4 suglasnika povezana bez _ , visoka je sansa da taj upit nece pronaci takvu rec 
						// ili je sansa izuzetno retka, takve reci u bazi ce imati 0 brojac uspesnih unosa ako uopste postoje
						$brojac_suglasnika++;

						if ($brojac_suglasnika > 3) 
						{
							// echo "rec ima vise od 3 suglasnika povezana u stringu";
							return FALSE; // rec ima vise od 3 suglasnika povezana u stringu, nije bitno na kom mestu jer takva rec je izuzetno retka
						}
					} /*elseif(in_array($spojeni, $GLOBALS['samoglasnici'])) {
						// echo "SLOVO JE SAmOGLASNIK";
					} else {
						// echo "1/2 od dva slova; 1/2 jednog slova+donja crta; ";
					}*/
				} 
			}
		}

		if($this->brojac_donjih_crta <= $this->min_donjih_crta)
		{
			//nijedan bajt nije jednak "_" i ne postoje 4+ vezana suglasnika
			return FALSE;
		} else {
			return TRUE;
		}	
		
	}
// --------------------------------------------------------------------------------------------------------------------------

// --------------------------------------------------------------------------------------------------------------------------
	public function uspesan_unos_reci($niz = array ())
	{
		
		if(isset($niz['kvalitet'])){
			unset($niz['kvalitet']);
		}

		if($niz)
		{
			array_push($GLOBALS['unete_reci'], $niz);
			array_push($GLOBALS['unete_reci_sa_putevima'], array($niz['rec'], $this->put_za_pretragu) );
		}
	}
// --------------------------------------------------------------------------------------------------------------------------
	public function ispisi_sve_unete_reci(){
		return $GLOBALS['unete_reci'];
	}
// --------------------------------------------------------------------------------------------------------------------------
	// vraca false ako nije potpuno popunjena slovima
	// vraca true ako je potpuno popunjena slovima
	public function da_li_je_osm_popunjena()
	{
		for($r = 1; $r <= $this->red_velicina_osmosmerke; $r++)
		{
			for($k = 1; $k <= $this->kolona_velicina_osmosmerke; $k++)
			{
				if($this->osmosmerka_niz[$r][$k] == "_")
				{
					return FALSE;
				}
			}
		}
		return TRUE;
	}
// --------------------------------------------------------------------------------------------------------------------------
	public function popunjavanje_preostalih_polja_osmosmerke()
	{		
		$niz_preostalih_polja = array();

		for($r = 1; $r <= $this->red_velicina_osmosmerke; $r++)
		{
			for($k = 1; $k <= $this->kolona_velicina_osmosmerke; $k++)
			{
				if($this->osmosmerka_niz[$r][$k] == "_")
				{
					array_push($niz_preostalih_polja, array($r, $k));
				}
			}
		}
		$this->put_za_pretragu = $niz_preostalih_polja;
		$br_preostalih_polja = count($niz_preostalih_polja);

		if ($br_preostalih_polja >= 3 AND $br_preostalih_polja <= 12){
			// popunjavanje preostalih polja osmosmerke iz baze

			// vise ne sme da vrati samo jednu rec, vec mi treba vise, ovaj broj nije bitan dok god se radi sa oko 40*40,
			// moze doci do greske ako ikad budem razvijao ovaj kod da radi sa mnogo vecim osmosmerkama
			// jer taj result set koji vrati, moze vec biti u osmosmerci, tako da metoda da li rec postoji u osmosmerci nece dozvoliti
			// unos nijedne od tih 50 reci, ali za sad necu da se desava da nadje ogroman broj kratkih 3-4-5 char reci i besmisleno trosi memoriju

			$this->koliko = 50;
			$this->rec_za_pretragu = "";
			$d_crta = "_";
			for($i = 1; $i <= $br_preostalih_polja; $i++){
				$this->rec_za_pretragu .= $d_crta;
			}

			$this->pretraga_baze();
			for($rec = 0; $rec < count($this->niz_pretrage); $rec++)
			{
				if($this->niz_pretrage[$rec]['rec'])
				{
					// var_dump($this->niz_pretrage[$rec]["rec"]);
					$this->razbijanje_reci_na_slova($this->niz_pretrage[$rec]);
					$this->unos_reci_u_osmosmerku();
					echo "Resenje osmosmerke je {$this->rec_za_unos_u_osmosmerku} - echo kraj osm klase";
					break;
				}
			}
			$this->resenje = $this->rec_za_unos_u_osmosmerku;
		} else {
			// preostalo je premalo ili previse praznih polja, jedan nacin da se to ispravi je da se u tabelu unesu reci duze od 12 slova ili u zasebnu tabelu 
			// $this->zatvor_klaster();
		}
		return $this->osmosmerka_niz;
	}
// --------------------------------------------------------------------------------------------------------------------------

// --------------------------------------------------------------------------------------------------------------------------
	public function azuriranje_brojac_uspesnih_unosa()
	{
		for($i = 0; $i < count($GLOBALS['unete_reci']); $i++)
		{
			// 
			if( isset($GLOBALS['unete_reci'][$i]['brojac_uspesnih_unosa']) )
			{
				$niz_az_brojac = array ('brojac_uspesnih_unosa' => $GLOBALS['unete_reci'][$i]['brojac_uspesnih_unosa'] + 1);
				$broj_slova_u_reci = mb_strlen($GLOBALS['unete_reci'][$i]['rec']);
				$tabela = "reci_osmosmerke_"."{$broj_slova_u_reci}";
				$this->bp_instanca->azuriraj_bp($tabela, $GLOBALS['unete_reci'][$i]['id'], $niz_az_brojac);
			}
		}
	}
// --------------------------------------------------------------------------------------------------------------------------
	// ovo nece imati svrhu nakon napravim JS fj-e za resavanje osm. ali ujedno i formira string od svih reci koje su onete u osm, kako bi 
	// se taj str uneo u tabelu
	public function ispisivanje_reci_osm()
	{
		$this->string_svih_reci = '';
		echo "<br>";
		for($i = 0; $i < count($GLOBALS['unete_reci']); $i++)
		{
			print_r($GLOBALS['unete_reci'][$i]['rec']);
			echo ", ";
			$this->string_svih_reci .= $GLOBALS['unete_reci'][$i]['rec'].'/'; // kasnije..................
		}
		echo "<br>";
		// print_r($GLOBALS['unete_reci']);
	}
// --------------------------------------------------------------------------------------------------------------------------
	public function unos_osmosmerke_u_bazu()
	{
		$osm = array(
				'id_korisnika' => $this->id_korisnika,
				'reci_osmosmerke' => $this->string_svih_reci,
				'niz_osmosmerke' => $this->osm_string, 
				'unet_red' => $this->red_velicina_osmosmerke,
				'unet_kolona' => $this->kolona_velicina_osmosmerke,
				'resenje_osmosmerke' => $this->resenje
						);
		if(!$this->bp_instanca->unesi('resene_osmosmerke', $osm))
		{
			throw new Exception('Догодио се проблем приликом уноса осмосмерке у базу.');
		}
	}
// --------------------------------------------------------------------------------------------------------------------------
	public function konverzija_osmosmerke_u_string() 
	{
		$this->osm_string = '';
		for($r = 1; $r <= $this->red_velicina_osmosmerke; $r++)
		{
			for($k = 1; $k <= $this->kolona_velicina_osmosmerke; $k++)
			{
				$this->osm_string .= $this->osmosmerka_niz[$r][$k];
			}
		}
		return $this->osm_string;
	}
// --------------------------------------------------------------------------------------------------------------------------
	public function trenutan_broj_praznih_polja()
	{
		if($this->brojac_donjih_crta != 0){
			$this->broj_preostalih_polja = $this->broj_preostalih_polja - $this->brojac_donjih_crta;
		}
		// echo $this->broj_preostalih_polja . ", ";
	}
// --------------------------------------------------------------------------------------------------------------------------
// 								metode za odredjivanje najkvalifikovanije reci za unos 
// kada se izvrsi upit i formira result set mogucih reci, ova metoda kvatifikuje svako od njih brojem kvaliteta u zavisnosti kojim slovima su okruzena
	// STO JE MANJA VREDNOST KVALITETA, TO JE BOLJA REC, NEmA SMISLA ALI NZNM KAKO DRUGACIJE DA JE IMENUJEM
// ideja je: unosi se rec slovo, na polju pored prvog slova "s" vec postoji slovo "s". To znaci da kada se bude formirala rec za upit, ona ce biti
// "...  _ _ s s _ _  ..." u srpskom jeziku ili ne postoje takva slova ili su izuzetno retka, ali se cesto desava u kodu, to mogu ukloniti sledecim funkcijama
// reci koje se posmatraju u nizu nisu unete u osmosmerku, ona rec koja ima najmanji kvalitet, ce biti uneta u osm, 
// formula za racunanje kvaliteta je :
// 		$kvalitet = 3 * $ukupan_broj_istih_sa_susedom + 0.5 * $ukupan_broj_suglasnika_sa_susedom;
// dakle ista slova polja sa susedom najvise uticu da ta rec ima visok kvalitet

// --------------------------------------------------------------------------------------------------------------------------	
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

		$najmanji_kvalitet = sortiranje_niza($this->niz_pretrage, 'kvalitet', TRUE);

		return $najmanji_kvalitet; 
	}

// --------------------------------------------------------------------------------------------------------------------------
	// TESKO JE NMG


	// popunjavanje zatvora/klastera je krajnji proces popunjavanja preostalih polja osmosmerke nakon sto se regularnim metodama ne dodje do > 12 
	// preostalih polja; prolazi se kroz osm i trazi se prazno polje, kad se nadje, loopuje se oko njega, kao talas i trazi se susedno zatvoreno polje
	// kada je klaster u pitanju, nacice ga odmah jer su klasteri grupe nepopunjenih polja koja su jedna do drugih u bilo kom smeru,
	// kada nadje 2 nepopunjena polja koja su u istom smeru, treba da isproba sve kombinacije duzina puteva, za oba smera sve dok ne pronadje rec u bazi
	// ako ne moze da nadje rec sa tim dodatnim klaster-poljem, prelazi na sledece klaster-polje i radi istu stvar
	// ako ne moze da poveze 2 polja putem, ili ne moze da nadje rec, onda se formira put za samo jedno polje u svim smerovima dok ne pronadje rec koja moze 
	// da popuni taj zatvor/klaster

	/*public function zatvor_klaster()
	{
		$niz_svih_nepopunjenih_polja = array();
		for($r = 1; $r <= $this->red_velicina_osmosmerke; $r++)
		{
			for($k = 1; $k <= $this->kolona_velicina_osmosmerke; $k++)
			{
				// da li je polje popunjeno
				if($this->osmosmerka_niz[$r][$k] == "_")
				{
					array_push($niz_svih_nepopunjenih_polja, array($r, $k));
				}
			}
		}

		for($polje = 0; $polje < count($niz_svih_nepopunjenih_polja); $polje++)
		{
			for($ostala_polja = 1; $ostala_polja < count($niz_svih_nepopunjenih_polja); $ostala_polja++) )
			{
				// ako polje za poredjenje(drugi loop) postoji, i nije isto kao ciljano polje(prvi loop)
				if(isset($niz_svih_nepopunjenih_polja[$ostala_polja]) AND $niz_svih_nepopunjenih_polja[$polje] != $niz_svih_nepopunjenih_polja[$ostala_polja])
				{
					// da li je polje $niz_svih_nepopunjenih_polja[$polje] u istoj horizontali, vertikali ili dijagonali sa 
					//$niz_svih_nepopunjenih_polja[$ostala_polja]

					$veca_kolona_je =  max($niz_svih_nepopunjenih_polja[$polje][1], $niz_svih_nepopunjenih_polja[$ostala_polja][1]);
					$manja_kolona_je = min($niz_svih_nepopunjenih_polja[$polje][1], $niz_svih_nepopunjenih_polja[$ostala_polja][1]);



					// horizontala? imaju isti red AND razlika kolona je u skupu [3,12]
					if( $niz_svih_nepopunjenih_polja[$polje][0] == $niz_svih_nepopunjenih_polja[$ostala_polja][0] AND
						( $veca_kolona_je - $manja_kolona_je >= 1 AND $veca_kolona_je - $manja_kolona_je <= 12 ) )
					{
						
					}
				}
				
			}
		}
	}*/
// --------------------------------------------------------------------------------------------------------------------------
	// fja krene od polja osmosmerke, i trazi susedni zatvor u istom smeru
	// public function zatvor_talas($r, $k)
	// {
	// 	for($red_talas = -1; $red_talas <= 1; $red_talas++)
	// 	{
	// 		for($kolona_talas = - 1; $kolona_talas <= 1; $kolona_talas++)
	// 		{
	// 			// susedno polje od zatvora ako postoji,ako je prazno i nije jedan od vec pronadjenih zatvora , nasao sam susedni zatvor; mora u IF kako bi se izbegao notice, ne postoji kljuc
	// 			if ( isset($this->osmosmerka_niz[$r - $red_talas][$k - $kolona_talas]) 
	// 				 AND $this->osmosmerka_niz[$r - $red_talas][$k - $kolona_talas] == "_"
	// 				 AND )
	// 			{
	// 				$sused_talas = $this->osmosmerka_niz[$r - $red_talas][$k - $kolona_talas];
	// 			}
				

	// 			if()
	// 		}
	// 	}

	// }

// --------------------------------------------------------------------------------------------------------------------------
}

