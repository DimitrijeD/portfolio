<?php
require_once 'osnova/inicijalizacija.php';
$korisnik = new Korisnik();
if (!$korisnik->je_ulogovan_k()) 
{
	Preusmeri::na('registracija.php');
}
if( (!$korisnik->ima_prava('admin')) ) 
{
	Preusmeri::na('index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
	<title>Тест базе</title>
</head>
<body>
	<div class="container">
		<ul id="stranice">
			<li><a href="index.php">Почетна страница</a></li>
			<li><a href="igraOsmosmerka.php"> Осмосмерка</a></li>
			<li><a href="kvadratna_spl.php"> Интерполација</a></li>
			<li><a href="asimetricna_osmosmerka.php">Асиметрична осмосмерка</a></li>
			

			<?php			
			if( ($korisnik->ima_prava('admin')) ) // ako je korisnik admin, prikazi mu ostale linkove
			{
			?>	
		
			<div class="dropdown">
				<div class="dropbtn">Алати за базу</div>
					<div class="dropdown-content">
						<a href="admin_stranica.php">Админ страница</a>		
						<a href="brisanje_reci_sa_neparnim_brojem_karaktera.php"> Брисање свих речи са непарним бројем карактера </a>
						<a href="brisanje_reci_sa_latinicnim_karakterom.php"> Брисање свих речи са латиничним карактером </a>						
						<a href="glomazni_unos_reci.php"> Алат за масовни/гломазни/bulk унос речи у табелу за попуњавање осмосмерки </a>
						<a href="test_tabele_osmosmerke.php"> Тест валидности табела за речи (reci_osm_N) </a>
					</div>
			</div>
			<div class="dropdown">
				<div class="dropbtn">Алати за осмосмерке</div>
					<div class="dropdown-content">
						<a href="testiranje_rada_klase_osmosmerka_templejt.php"> Алат за тестирање рада класе Osmosmerka_tempejt </a>
						<a href="pravljenje_ogromnih_osmosmerki.php"> Страница за прављење огромних осмосмерки </a> 
					</div>
			</div>
			<?php } ?>
			<li style="float: right; margin: 0; padding: 0px 5px"><a style="margin: 10px; padding: 5px 10px 5px 5px" href="odjava.php">Одјава</a></li>	
		</ul>
	
	<?php
	if( !($korisnik->ima_prava('admin')) ){
		Preusmeri::na('index.php');
	}
// ----------------------------------------------------------------------------------------------------------------------
	$bp_instanca = Baza_podataka::vrati_instancu();
	$ukupan_broj_reci = 0;

	echo '<div class="dodatni_podaci">';
	echo '<h3>Тест за проверу да ли у табелама <strong> "reci_osm_N" </strong> постоје <strong> речи </strong> које нису дужине N ( gde N &#8712; [3,...12] ). </h3>';

	$broj_reci_po_tabelama = array();
	$sve_kvarne_reci = array();
	$tablica = '<table id="tablica_baza">'; // za prikaz na ekranu
	$tablica .= '<tr>	<td>Табела базе</td>	<td>Бр. речи у табели</td>	   <td>Бр. кварних речи</td>    <td>Листа кварних речи</td>	</tr>';
	for($n = 3; $n <= 12; $n++)
	{
		$tablica .= '<tr>';
		$tabela = "reci_osmosmerke_"."{$n}"; // tabela baze podataka
		$tablica .= '<td>' . $tabela . '</td>';
		$kvarna_rec = '';
		$br_kvarnih_reci = 0;
		$lista_kvarnih_reci = '';

		$bp_instanca->pronadji($tabela, array('rec', 'LIKE', '%')); 
		$niz_pretrage = $bp_instanca->rezultati_bp();
		$niz_pretrage = json_decode(json_encode($niz_pretrage), true);
		$broj_reci_koje_pripadaju = 0;

		/*echo "<h4>Tabela {$tabela}</h4>";*/

		for($rec = 0; $rec < count($niz_pretrage); $rec++)
		{
			if( mb_strlen($niz_pretrage[$rec]['rec']) != $n){
				$duzina_reci_iz_baze = mb_strlen($niz_pretrage[$rec]['rec']);

				$kvarna_rec .= '<h5 style="background-color:#ff8080; margin-top:30px;color:black;font-size: 20px" >Пажња:</h5>';
				$kvarna_rec .= '</h5 style="background-color:#ff8080;">' . '<strong style="font-size: 18px;color:black;">'. $niz_pretrage[$rec]['rec'] . '</strong> реч не припада у табели <strong>' . $tabela . '</strong></h5>';				
				$kvarna_rec .= "</h5>Реч је дужине <strong>{$duzina_reci_iz_baze}</strong> слова, а мора да буде тачно <strong>{$n}</strong> .</h5>";		
				$br_kvarnih_reci++;
				$lista_kvarnih_reci .=  $niz_pretrage[$rec]['rec'] . ", ";
			} else {
				$broj_reci_koje_pripadaju++;
			}
		}

		$broj_reci_po_tabelama[$tabela] = $broj_reci_koje_pripadaju;
		$ukupan_broj_reci += $broj_reci_koje_pripadaju;
		$tablica .= "<td>" . $broj_reci_po_tabelama[$tabela] . "</strong></td>";
		$tablica .= '<td>' . $br_kvarnih_reci . '</td>';
		if(!empty($lista_kvarnih_reci))
		{
			$tablica .= "<td><strong>" . $lista_kvarnih_reci . "</strong></td>";
		} else {
			$tablica .= "<td><strong>/</strong></td>";
		}
		$tablica .= '</tr>';

		if(!empty($kvarna_rec)){
			$sve_kvarne_reci[] = $kvarna_rec;
		}
		
	}
	$tablica .= '</table>';
	echo $tablica;
	if(!empty($sve_kvarne_reci)){
		echo '<div id="greske">';
		foreach ($sve_kvarne_reci as $key => $value) {
			echo $value . ", ";
		}
		echo '</div>';
	}

	echo "</div>";
	echo "<br><br><h5>Ukupan broj reci od kojih se prave osmosmerke je <strong>{$ukupan_broj_reci}</strong></h5>"; 
	

// ----------------------------------------------------------------------------------------------------------------------
	// kod za razdvajanje tabele reci_osmosmerke na 10 tabela u kojima su reci iste duzine
	/*
	$bp_instanca->pronadji('reci_osmosmerke', array('rec', 'LIKE', '%')); 
	$niz_pretrage = $bp_instanca->rezultati_bp();
	$niz_pretrage = json_decode(json_encode($niz_pretrage), true);

	for($rec = 0; $rec < count($niz_pretrage); $rec++)
	{

		$duzina_reci = mb_strlen($niz_pretrage[$rec]['rec']);
		if($duzina_reci === 12)
		{
			// echo $rec . ". " . $niz_pretrage[$rec]['rec'] . "<br>";
			$bp_instanca = Baza_podataka::vrati_instancu();
			$bp_instanca->unesi('reci_osmosmerke_12', array('rec'=>$niz_pretrage[$rec]['rec'])); 
		}
	}
	*/
// ----------------------------------------------------------------------------------------------------------------------
	/*	
	echo "Reči sa 4 vezana suglasnika u sebi (na bilo kom mestu): " . "<br>";
	$br_test = 0;
	for($rec = 0; $rec < count($niz_pretrage); $rec++ )
	{
		for($pozicija_u_reci = 0; $pozicija_u_reci < mb_strlen($niz_pretrage[$rec]['rec']); $pozicija_u_reci++ )
		{
			if(isset($niz_pretrage[$rec]['rec'][$pozicija_u_reci + 1]))
			{
				var_dump($niz_pretrage[$rec]['rec'][$pozicija_u_reci].$niz_pretrage[$rec]['rec'][++$pozicija_u_reci] );
				if(  $niz_pretrage[$rec]['rec'][$pozicija_u_reci].$niz_pretrage[$rec]['rec'][$pozicija_u_reci+1] != "а" AND 
				     $niz_pretrage[$rec]['rec'][$pozicija_u_reci].$niz_pretrage[$rec]['rec'][$pozicija_u_reci+1] != "е" AND 
				     $niz_pretrage[$rec]['rec'][$pozicija_u_reci].$niz_pretrage[$rec]['rec'][$pozicija_u_reci+1] != "и" AND 
				     $niz_pretrage[$rec]['rec'][$pozicija_u_reci].$niz_pretrage[$rec]['rec'][$pozicija_u_reci+1] != "о" AND 
				     $niz_pretrage[$rec]['rec'][$pozicija_u_reci].$niz_pretrage[$rec]['rec'][$pozicija_u_reci+1] != "у"  
				    )
				{
					$br_test++;
					if($br_test > 3)
					{
						echo "<br>" . "reč sa 4 vezana suglasnika je: " . $niz_pretrage[$rec]['rec'] . "<br>";
					}
				} 
				$br_test = 0;
								
			}
			$pozicija_u_reci++;
		}
		
	}
	*/
// ----------------------------------------------------------------------------------------------------------------------
	/*
	echo "<p>Табела <b>свих речи</b> од којих се прави осмосмерка</p>";
	echo("<table>");
	echo('<tr>');
		echo('<th>ID</th>');
		echo('<th>rec</th>');
		echo('<th>brojac_uspesnih_unosa</th>');
		echo('<th>brojac_neuspesnih_unosa</th>');
	echo('</tr>');

	foreach ($niz_pretrage as $rec) 
	{
		echo('<tr>'); 
			echo('<td>'); 
				print_r($rec['id']);  
			echo('</td>');
			echo('<td>'); 
				print_r($rec['rec']);  
			echo('</td>');
			echo('<td>'); 
				print_r($rec['brojac_uspesnih_unosa']);  
			echo('</td>');
			echo('<td>'); 
				print_r($rec['brojac_neuspesnih_unosa']);  
			echo('</td>');
		echo('</tr>'); 
	}
	echo('</table>'); 
	echo "<br>";
	echo "<p1>Укупан број речи у табели 'reci_osmosmerke' je:  </p1>";
	print_r(count($niz_pretrage));
	echo "<br>";
	*/

	?>
	
	<div id="content-wrap">
		<footer id="footer"><small>&copy; Copyright 2021.   Dimitrije Drakulić</small></footer>
	</div>
	
	</div>
</body>
</html>
