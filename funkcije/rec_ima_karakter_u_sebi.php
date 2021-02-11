<?php

function rec_ima_karakter_u_sebi($rec, $trazeno_slovo)
{
	for($i = 0; $i < mb_strlen($rec); $i++)
	{
		if($trazeno_slovo == $rec[$i])
		{
			return TRUE; //rec nema trazno slovo u sebi
		}
	}
	return FALSE;
}

