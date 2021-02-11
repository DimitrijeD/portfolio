<?php
function ocisti($string)
{
	return htmlentities($string, ENT_QUOTES, 'UTF-8');
}