<?php

function resenje_osmosmerke()
{
	$forma = '<br><br><p class="horizontalno_centriraj_text">Након проналаска свих слова са списка формирајте решење и унесите га у форму: </p>
				<br><form name="forma_za_resenje" style="margin: auto; width: 50%;">
	 				 Решење:  <input type="text" id="resenje" name="resenje"></input> 
	  				 <button type="button" onclick="konacno_resenje_obj.provera_resenja()">Коначно решење</button>
			     </form><br><br><br>';
	return $forma;
}

?>