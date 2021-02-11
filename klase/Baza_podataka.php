<?php
class Baza_podataka{
	private static $bp_instanca = NULL;
	private $_pdo, 
			$_upit, 
			$_greska = FALSE, 
			$_rezultati, 
			$_br_redova = 0;
//-------------------------------------------------------------------------------------------------------------------
	private function __construct()
	{
		try{
			$this->_pdo = new PDO('mysql:host=' . Konfiguracija::vrati_konf('mysql/domacin') . ';dbname=' . Konfiguracija::vrati_konf('mysql/baza_podataka'), Konfiguracija::vrati_konf('mysql/korisnicko_ime_bp'), Konfiguracija::vrati_konf('mysql/sifra_bp'));
			// echo "povezan";
		}
		catch(PDOException $e){
			die($e->getMessage());
		}
	}
//--------------------------------------------------------------------------------------------------------------------
	// -- Instanciranje klase ako ne postoji vec njena instanca --
	public static function vrati_instancu()
	{
		if(!isset(self::$bp_instanca))
		{
			self::$bp_instanca = new Baza_podataka();
		}
		return self::$bp_instanca;
	}
//--------------------------------------------------------------------------------------------------------------------
	public function upit($sql, $parametri = array())
	{
		$this->_greska = FALSE;
		if($this->_upit = $this->_pdo->prepare($sql))
		{
			$x = 1;
			if(count($parametri))
			{
				foreach ($parametri as $_parametar) 
				{
					$this->_upit->bindValue($x, $_parametar);
					$x++;
				}
			}
			if($this->_upit->execute())
			{
				$this->_rezultati = $this->_upit->fetchAll(PDO::FETCH_OBJ);
				$this->_br_redova = $this->_upit->rowCount();
			} else {
				$this->_greska = TRUE;
			}
		}
		return $this;
	}
//--------------------------------------------------------------------------------------------------------------------
	public function priprema ($tip_upita, $tabela, $_gde = array(), $koliko = NULL)
	{
		if(count($_gde) === 3)
		{
			$operatori = array('=', '<', '>', '<=', '>=', 'LIKE');

			$kolona = $_gde[0];
			$operator = $_gde[1];
			$vrednost_parametara = $_gde[2];
			// var_dump($vrednost_parametara);

			// f-ja proverava da li vrednost postoji u nizu
			if(in_array($operator, $operatori))
			{
				if($koliko)
				{
					$sql = "{$tip_upita} FROM {$tabela} WHERE {$kolona} {$operator} ? ORDER BY brojac_uspesnih_unosa LIMIT {$koliko}";
				} else {
					$sql = "{$tip_upita} FROM {$tabela} WHERE {$kolona} {$operator} ?";
				}

				if(!$this->upit($sql, array($vrednost_parametara))->greska_u_pretrazi())
				{
					return $this;
				}
			}
		}
		return FALSE;
	}
//--------------------------------------------------------------------------------------------------------------------
	public function pronadji($tabela, $_gde, $koliko = NULL)//, $koliko = ''
	{
		if ($koliko){
			return $this->priprema('SELECT *', $tabela, $_gde, $koliko);
		} else {
			return $this->priprema('SELECT *', $tabela, $_gde);
		}
	}
//--------------------------------------------------------------------------------------------------------------------
	public function obrisi($tabela, $_gde)
	{
		return $this->priprema('DELETE', $tabela, $_gde);
	}
//--------------------------------------------------------------------------------------------------------------------
	public function unesi($tabela, $polja = array()) 
	{
		$kljucevi = array_keys($polja);
		$vrednosti = ' ';
		$x = 1;
		// print_r($polja);
		foreach($polja as $polje) 
		{
			$vrednosti .= '?';
			if($x < count($polja)) 
			{
				$vrednosti .= ', ';
				// print_r($vrednosti);
			}
			$x++;
			// koliko ima unetih vrednosti, toliko raznakUputnik uneti za pripremu SQL
		}

		$sql = "INSERT INTO {$tabela} (`" . implode('`, `', $kljucevi) . "`) VALUES ({$vrednosti})";

		if(!$this->upit($sql, $polja)->greska_u_pretrazi()) 
		{
			return true;
		}
		return false;
	}
//------------------------------------------------------------------------------------------------------------------
	
//------------------------------------------------------------------------------------------------------------------
	public function azuriraj_bp($tabela, $id, $polja)
	{
		$postavi = '';
		$x = 1;

		foreach($polja as $ime => $vrednost)
		{
			$postavi .= "{$ime} = ?";
			if($x < count($polja))
			{
				$postavi .= ', ';
			}
			$x++;
		}

		$sql = "UPDATE {$tabela} SET {$postavi} WHERE id = {$id}";

		if(!$this->upit($sql, $polja)->greska_u_pretrazi())
		{
			return TRUE; 
		}
		return FALSE;
	}
//--------------------------------------------------------------------------------------------------------------
	public function rezultati_bp()
	{
		return $this->_rezultati;
	}
//--------------------------------------------------------------------------------------------------------------
	public function prvi_rez()
	{
		return $this->rezultati_bp()[0];
	}
//--------------------------------------------------------------------------------------------------------------
	public function greska_u_pretrazi()
	{
		return $this->_greska;
	}
//--------------------------------------------------------------------------------------------------------------
	public function br_redova()
	{
		return $this->_br_redova;
	}
//--------------------------------------------------------------------------------------------------------------
}
