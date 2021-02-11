<?php

/*
//neka je globalni niz sad isti kao test niz $a
$GLOBALS['unete_reci'] = array(array ('id' => "1", 'rec' => "voz", 'brojac_uspesnih_unosa' => 0, 'brojac_neuspesnih_unosa' => 0),
							   array ('id' => "2", 'rec' => "krov", 'brojac_uspesnih_unosa' => 0, 'brojac_neuspesnih_unosa' => 0),
							   array ('id' => "3", 'rec' => "rok", 'brojac_uspesnih_unosa' => 0, 'brojac_neuspesnih_unosa' => 0),
								array ('id' => "2", 'rec' => "konacnoa", 'brojac_uspesnih_unosa' => 0, 'brojac_neuspesnih_unosa' => 0));

// neka je ovo test niz
					$a = array( array ('id' => "1", 'rec' => "voz", 'brojac_uspesnih_unosa' => 0, 'brojac_neuspesnih_unosa' => 0),
								array ('id' => "3", 'rec' => "rok", 'brojac_uspesnih_unosa' => 0, 'brojac_neuspesnih_unosa' => 0),
								array ('id' => "4", 'rec' => "kompjuter", 'brojac_uspesnih_unosa' => 0, 'brojac_neuspesnih_unosa' => 0),
								array ('id' => "2", 'rec' => "krov", 'brojac_uspesnih_unosa' => 0, 'brojac_neuspesnih_unosa' => 0),
								array ('id' => "2", 'rec' => "konacno", 'brojac_uspesnih_unosa' => 0, 'brojac_neuspesnih_unosa' => 0));

*/

function poslednji_kljuc_niza($niz = array())
{
	if(!$niz){
		return FALSE;
	}
	end($niz);
	$kljuc = key($niz);
	reset($niz);
	return $kljuc;
}

function da_li_rec_postoji_u_osmosmerci($niz_pretrage = array())
{
	$rezultat = array();
		//ako je prazan
	if(!$niz_pretrage){
		// echo "prazan niz pretrage, rezultat upita je 0";
		return FALSE;
	}

	$niz_pretrage = json_decode(json_encode($niz_pretrage), true);
		
		//ako je prazan
	if(!$GLOBALS['unete_reci']){
		// echo "prazan global, sve reci mogu stati";
		// print_r($niz_pretrage);
		return $niz_pretrage;
	}

	//petlja za niz pretrage
	for($j = 0; $j < count($niz_pretrage); $j++)
	{
		//petlja za globalni niz
		for($i = 0; $i < count($GLOBALS['unete_reci']) ; $i++)
		{
			if( $GLOBALS['unete_reci'][$i]['rec'] == $niz_pretrage[$j]['rec'])
			{
				// xdddddddddddddd
				$niz_pretrage[$j]['id'] = NULL; 
				$niz_pretrage[$j]['rec'] = NULL;
				$niz_pretrage[$j]['brojac_uspesnih_unosa'] = NULL;
				$niz_pretrage[$j]['brojac_neuspesnih_unosa'] = NULL;
			} 
		}
	}

	if(empty($niz_pretrage)){
		// echo "<br>";
		// echo "prazan niz pretrage, sve reci koje su odabrane za unos su izbrisane u petlji!";
		// echo "<br>";
		return false;
	}

	for ($i = 0; $i < count($niz_pretrage); $i++) { 
		if($niz_pretrage[$i]['rec'])
		{
			array_push($rezultat, $niz_pretrage[$i]);
		}
	}

	// echo "<br>" . "------------------Konacno resenje niz_pretrage-------------------" . "<br>";
	// print("<pre>");
	// 	print_r($rezultat);
	// print("</pre>");
	// echo "<br>";
	return $rezultat;

}




