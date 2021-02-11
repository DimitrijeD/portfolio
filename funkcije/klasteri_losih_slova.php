 <?php
// funkcija proverava da li dva spojena bajta formiraju suglasnik
// function klasteri_losih_slova($rec)
// {
// 	$suglasnici = array(  "Б", "В", "Г", "Д", "Ђ", "Ж", "З", "Ј", "К", "Л", "Љ", "М", "Н", "Њ", "П", "С", "Т", "Ћ", "Ф", "Х", "Ц", "Ч", "Џ", "Ш" );
// 	$samoglasnici = array ("А", "Е", "И", "О", "У", "Р");

// 	$brojac_donjih_crta = 0;

// 	$brojac_suglasnika = 0; // resetuj ga na nula

// 	if($rec)
// 	{
// 		for($i = 0; $i < strlen($rec); $i++)
// 		{
// 			echo "<br>" . $i . ". ciklus -";
		
// 			if($rec[$i] == "_")
// 			{
// 				echo "karakter je _";
// 				$brojac_donjih_crta++; 
// 				$brojac_suglasnika = 0;
// 			} elseif (isset($rec[$i + 1]))
// 			{
// 				$spojeni = $rec[$i].$rec[$i + 1];
// 				if(in_array($spojeni, $suglasnici)) 
// 				{ 
// 					echo "SLOVO JE SUGLASNIK";
// 					// brojac_suglasnika - ideja je da ako su u stringu 4 suglasnika povezana bez _ , visoka je sansa da taj upit nece pronaci takvu rec 
// 					$brojac_suglasnika++;

// 					if ($brojac_suglasnika > 3) 
// 					{
// 						return FALSE; // rec ima vise od 3 suglasnika povezana u stringu, nije bitno na kom mestu jer takva rec je izuzetno retka
// 					}
// 				} elseif(in_array($spojeni, $samoglasnici)) {
// 					echo "SLOVO JE SAOGLASNIK";
// 				} else {
// 					echo "1/2 od dva slova; 1/2 jednog slova+donja crta; ";
// 				}
// 			} 
// 		}
// 	}
// 	echo "<br>"."brojac donjih crta = " . $brojac_donjih_crta . "<br>";
// 	echo "<br>" . "brojac suglasnika = " . $brojac_suglasnika . "<br>";
// 	if($brojac_donjih_crta == 0)
// 	{
// 		//nijedan bajt nije jednak "_" i ne postoje 4+ vezana suglasnika
// 		return FALSE;
// 	} else {
// 		return TRUE;
// 	}	
	
// }
// $rec = "С_ОВ_ТХ";
// // print_r(strlen($rec)); // vraca koliko bajtova ima

// // echo "<br>" . "0,1 - ";
// $a = klasteri_losih_slova($rec);
// // echo "<br>";

// // echo $rec[4].$rec[5];


// $a = "реч";

// echo $a[0].$a[1];



?>