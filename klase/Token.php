<?php
class Token
{
	public static function napravi_t()
	{
		return Sesija::postavi(Konfiguracija::vrati_konf('sesija/ime_tokena'), md5(uniqid()));
	}

	// provera da li ovaj token postoji u globalnom nizu ili ne
	public static function proveri_t($token)
	{
		$ime_tokena = Konfiguracija::vrati_konf('sesija/ime_tokena');

		if(Sesija::postoji($ime_tokena) && $token === Sesija::vrati($ime_tokena))
		{
			Sesija::obrisi($ime_tokena);
			return TRUE;
		}
		return FALSE;
	}
}

