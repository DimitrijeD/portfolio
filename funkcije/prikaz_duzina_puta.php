<?php

function prikaz_duzina_puta($niz)
{
	for($i = 0; $i < count($niz); $i++)
	{
		echo "     " . count($niz[$i]);
	}
}