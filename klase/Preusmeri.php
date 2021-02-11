<?php
class Preusmeri
{
	public static function na($lokacija = NULL)
	{
		if($lokacija)
		{
			if(is_numeric($lokacija))
			{
				switch($lokacija)
				{
					case 404:
						header('HTTP/1.0 404 Страница није пронађена!');
						include 'greske/404.php';
						exit();
					break;
				}
			}
			header('location: ' . $lokacija);
			exit();
		}
	}
}