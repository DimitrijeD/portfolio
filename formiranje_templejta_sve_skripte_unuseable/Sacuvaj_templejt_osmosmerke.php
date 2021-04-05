<?php

// ----------------------------------------------------------- KLASA KORISCENA ZA PRAVLJENJE FAJLOVA TEMPLEJTA---------------------------//
// ----------------------------------------------------------- TEST FAILED --------------------------------------------------------------//

class Sacuvaj_templejt_osmosmerke
{
	public $red_velicina_osmosmerke,
	 	   $kolona_velicina_osmosmerke;

// --------------------------------------------------------------------------------------------------------------------------

	public function __construct($red_velicina_osmosmerke, $kolona_velicina_osmosmerke)
	{
		// 
		$this->red_velicina_osmosmerke = $red_velicina_osmosmerke;
	    $this->kolona_velicina_osmosmerke = $kolona_velicina_osmosmerke;

	}

// --------------------------------------------------------------------------------------------------------------------------

	// metoda proverava da li je vec ranije napravljen i sacuvan templejt za ovu duzinu
	public function da_li_postoji_fajl()
	{
		$this->napravi_naziv_fajla($this->red_velicina_osmosmerke, $this->kolona_velicina_osmosmerke);
		// var_dump('../templejti_osmosmerke/' . $this->naziv_fajla);
		if(file_exists('./templejti_osmosmerke/' . $this->naziv_fajla))
		{
			return false;
			// echo "fajl vec postoji!!!!";
			// nema razloga da se vise bilo sta radi
		} else {
			// ne postoji fajl, moze da se nastavi sa radom
			$this->sacuvaj_niz_svih_puteva(); // pozovi funkciju 
		}
	}

// --------------------------------------------------------------------------------------------------------------------------

	// sacuvani niz svih puteva treba da bude podeljen na razlicite duzine kako bi se pre formiranja nove osmosmerke,
	// svaki od tih individualnih duzina, shuffle i dodala doza nasumicnosti umesto da sve r*k imaju istu strukturu
	public function sacuvaj_niz_svih_puteva()
	{
		$templejt = new Osmosmerka_templejt($this->red_velicina_osmosmerke, $this->kolona_velicina_osmosmerke, array(), array(), 12);
		$templejt->svi_putevi();
		$niz_svih_puteva_za_fajl = $templejt->niz_svih_puteva_za_fajl();
		$var_str = var_export($niz_svih_puteva_za_fajl, true);
		$var = "<?php\n\n\$niz_svih_puteva_za_fajl = $var_str;\n\n?>";
		file_put_contents('templejti_osmosmerke/' . $this->naziv_fajla, $var);
		return true;

	}

// --------------------------------------------------------------------------------------------------------------------------
	// primer naziva fajla za 3*4 osmosmerku:
	//	3x4.php
	private function napravi_naziv_fajla($r, $k)
	{
		$this->naziv_fajla = $r . "x" . $k . ".php";
		return $this->naziv_fajla;
	}

// --------------------------------------------------------------------------------------------------------------------------



// --------------------------------------------------------------------------------------------------------------------------
}

?>