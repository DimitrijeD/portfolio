<?php
class Kolacic
{
	public static function kolacic_postoji($ime)
	{
		if(isset($_COOKIE[$ime])){
			return TRUE;
		} else {
			return FALSE;
		}
	}
//-------------------------------------------------------------------------------------------------------------
	public static function kolacic_vrati($ime)
	{
		return $_COOKIE[$ime];
	}
//-------------------------------------------------------------------------------------------------------------
	public static function postavi_kolacic($ime, $vrednost, $istice)
	{
		if(setcookie($ime, $vrednost, time() + $istice, '/'))
		{
			return TRUE;
		}
		return FALSE;
	}
//-------------------------------------------------------------------------------------------------------------
	public static function obrisi_kolacic($ime)
	{
		self::postavi_kolacic($ime, '', time() - 1);
	}
//-------------------------------------------------------------------------------------------------------------
}