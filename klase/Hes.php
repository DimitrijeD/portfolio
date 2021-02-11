<?php
class Hes // Heš
{
	public static function napravi($string, $so = '')
	{
		return hash('sha256', $string . $so); // https://www.php.net/manual/en/function.hash.php
	}
//-----------------------------------------------------------------------------------------------------------------------
	public static function so($duzina)
	{
		return bin2hex( random_bytes($duzina/2) );
	}
//-----------------------------------------------------------------------------------------------------------------------
	public static function jedinstven()
	{
		return self::napravi(uniqid());
	}
}