<?php
class Korisnik
{
	private $bp_instanca,
			$podaci_jednog_korisnika,
			$ime_sesije,
			$ime_kolacica,
			$korisnik_prijavljen;
//--------------------------------------------------------------------------------------------------------------------
	public function __construct($korisnik = NULL)
	{
		$this->bp_instanca = Baza_podataka::vrati_instancu();

		$this->ime_sesije = Konfiguracija::vrati_konf('sesija/ime_sesije');
		$this->ime_kolacica = Konfiguracija::vrati_konf('zapamti_me/ime_kolacica');

		if(!$korisnik)
		{
			if(Sesija::postoji($this->ime_sesije))
			{
				$korisnik = Sesija::vrati($this->ime_sesije);
				if($this->nadji_k($korisnik)) 
				{
					$this->korisnik_prijavljen = TRUE;
				} else {
					//proces odjave
				}
			}
		} else {

			$this->nadji_k($korisnik);
		}
	}
//--------------------------------------------------------------------------------------------------------------------
	public function azuriraj_k($polja = array(), $id = null)
	{
		if(!$id && $this->je_ulogovan_k())
		{
			$id = $this->podaci_k()->id;
		}

		if(!$this->bp_instanca->azuriraj_bp('korisnici', $id, $polja))
		{
			throw new Exception ('Догодио се проблем приликом ажурирања.');
		}
	}
//--------------------------------------------------------------------------------------------------------------------
	public function napravi_k($polja = array())
	{
		if(!$this->bp_instanca->unesi('korisnici', $polja))
		{
			throw new Exception('Догодио се проблем приликом прављења профила.');
		}
	}

//--------------------------------------------------------------------------------------------------------------------
	public function nadji_k($korisnik = NULL)
	{
		if($korisnik)
		{
			//pretraga korisnika po ID ako je $korisnik int
			$polje = (is_numeric($korisnik)) ? 'id' : 'email';
			// $data predstavlja podatke koji se dobiju iz tabele
			$pretraga_korisnika = $this->bp_instanca->pronadji('korisnici', array($polje, '=', $korisnik));

			// Ovo znaci da korisnik zapravo postoji, tj ako je TRUE u if
			if ($pretraga_korisnika->br_redova())
			{
				$this->podaci_jednog_korisnika = $pretraga_korisnika->prvi_rez();
				return TRUE;
			}
		}
		return FALSE;
	}
//--------------------------------------------------------------------------------------------------------------------
	public function prijavi_k($korisnicko_ime = NULL, $sifra = NULL, $zapamti_me = FALSE)
	{
		if(!$korisnicko_ime && !$sifra && $this->postoji_k())
		{
			Sesija::postavi($this->ime_sesije, $this->podaci_k()->id);
		} 
		
		else 
		{ 
			$korisnik = $this->nadji_k($korisnicko_ime);
		
			if($korisnik)
			{
				if ( $this->podaci_k()->sifra === Hes::napravi($sifra, $this->podaci_k()->t_so) )
				{
					Sesija::postavi($this->ime_sesije, $this->podaci_k()->id);
					if($zapamti_me)
					{
						$hes_ = Hes::jedinstven();
						$hes_provera = $this->bp_instanca->pronadji('sesije_korisnika', array('id_korisnika', '=', $this->podaci_k()->id));

						if(!$hes_provera->br_redova())
						{
							$this->bp_instanca->unesi('sesije_korisnika', array(
									'id_korisnika' => $this->podaci_k()->id,
									't_hes' => $hes_
								));
						} else {
							$hes_ = $hes_provera->prvi_rez()->hes_;
						}

						Kolacic::postavi_kolacic($this->ime_kolacica, $hes_, Konfiguracija::vrati_konf('zapamti_me/kolacic_istice'));
					}
					return TRUE;
				}
			}
		}
		return FALSE;
	}
//--------------------------------------------------------------------------------------------------------------------
	public function ima_prava($kljuc)
	{		
		$tip_korisnika = $this->bp_instanca->pronadji('vrste_korisnika', array('id', '=', $this->podaci_k()->tip_korisnika));
		if($tip_korisnika->br_redova())
		{
			// var_dump($tip_korisnika->prvi_rez()->ovlascenje);
			$ovlascenje = json_decode ($tip_korisnika->prvi_rez()->ovlascenje, TRUE);
			// var_dump($ovlascenje);
			if(isset($ovlascenje[$kljuc]) AND $ovlascenje[$kljuc] == TRUE)
			{
				return TRUE;
			}
		}
		return FALSE;
	}
//--------------------------------------------------------------------------------------------------------------------
	public function postoji_k()
	{
		if(!empty($this->podaci_jednog_korisnika)){
			return TRUE;
		} else {
			return FALSE;
		}
	}

//--------------------------------------------------------------------------------------------------------------------
	public function napravio_osmosmerku(){
		$br_zahtevanih_osm_azuriran = $this->podaci_jednog_korisnika->br_zahtevanih_osm + 1;
		$this->bp_instanca->azuriraj_bp('korisnici', $this->podaci_jednog_korisnika->id,  array('br_zahtevanih_osm' => $br_zahtevanih_osm_azuriran) );
	}
//--------------------------------------------------------------------------------------------------------------------
	public function odjavi_k()
	{
		$this->bp_instanca->obrisi('sesije_korisnika', array('id_korisnika', '=', $this->podaci_k()->id));

		Sesija::obrisi($this->ime_sesije);
		Kolacic::obrisi_kolacic($this->ime_kolacica);
	}
//--------------------------------------------------------------------------------------------------------------------
	public function podaci_k()
	{
		return $this->podaci_jednog_korisnika;
	}
//--------------------------------------------------------------------------------------------------------------------
	public function je_ulogovan_k()
	{
		return $this->korisnik_prijavljen;
	}
//--------------------------------------------------------------------------------------------------------------------

}