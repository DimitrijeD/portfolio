<?php
class Sesija
{
	public static function postoji($ime)
	{
		if(isset($_SESSION[$ime])){
			return TRUE;
		} else {
			return FALSE;
		}
	}
//----------------------------------------------------------------------------------------------------
	public static function postavi($ime, $vrednost)
	{
		return $_SESSION[$ime] = $vrednost;
	}
//----------------------------------------------------------------------------------------------------
	public static function vrati($ime)
	{
		return $_SESSION[$ime];
	}
//----------------------------------------------------------------------------------------------------
	public static function obrisi($ime)
	{
		if(self::postoji($ime))
		{
			unset($_SESSION[$ime]);
		}
	}
//----------------------------------------------------------------------------------------------------
	public static function prikazi_jednom($ime, $string = '')
	{
		if(self::postoji($ime))
		{
			$sesija = self::vrati($ime);
			self::obrisi($ime);
			return $sesija;
		} else {
			self::postavi($ime, $string);
		}
	}
//----------------------------------------------------------------------------------------------------
}