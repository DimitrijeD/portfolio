<?php
class Input
{
	public static function postoji($tip_inputa = 'post')
	{
		switch($tip_inputa)
		{
			case 'post':
				if(!empty($_POST)){
					return TRUE;
				} else {
					return FALSE;
				}
			break;

			case 'get':
				if(!empty($_GET)){
					return TRUE;
				} else {
					return FALSE;
				}
			break;
			
			default:
				return FALSE;
			break;
		}
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
	public static function vrati($podatak)
	{
		if(isset($_POST[$podatak]))
		{
			return $_POST[$podatak];
		}
		else if(isset($_GET[$podatak]))
		{
			return $_GET[$podatak];
		}
		return '';
	}
}

