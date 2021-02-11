<?php
class Konfiguracija
{
	// metoda koja primi string, tj. put do promenljive koja se nalazi u globalnom nizu, i vraca vrednost na koju taj put pokazuje
	public static function vrati_konf($put_do_konfig_vrednosti = NULL)
	{
		if($put_do_konfig_vrednosti)
		{
			$konfiguracija_glob = $GLOBALS['niz_konfiguracija'];
			$put_do_konfig_vrednosti = explode('/', $put_do_konfig_vrednosti);

			foreach ($put_do_konfig_vrednosti as $deo_puta) 
			{
				if(isset($konfiguracija_glob[$deo_puta]))
				{
					$konfiguracija_glob = $konfiguracija_glob[$deo_puta];
				}
			}
			return $konfiguracija_glob;
		}
		return FALSE;
	}
}
