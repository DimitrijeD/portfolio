<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/stil.css">
</head>
<body>
	<div class="container">
		<ul>
			<li><a href="pocetna_stranica.php">Почетна страница</a></li>

			<li><a href="igraOsmosmerka.php">Игра осмосмерка</a></li>
			<li><a href="odjava.php">Одјава</a></li>
		</ul><br>
		<p1>Алати за одржавање валидности карактера у речима од којих се формирају осмосмерке</p1>
		<ul>
			<li><a href="tabela_svih_reci_za_osmosmerke.php">Приказ свих речи од којих се праве осмосмерке</a></li> 
			<li><a href="brisanje_reci_sa_neparnim_brojem_karaktera.php"> Брисање свих речи са непарним бројем карактера </a></li>
			<li><a href="brisanje_reci_sa_latinicnim_karakterom.php"> Брисање свих речи са латиничним карактером </a></li>
		</ul>
		<p1>Други алати</p1>
		<ul>
			<li><a href="skripte_za_testiranje/testiranje_rada_klase_osmosmerka_templejt.php"> Алат за тестирање рада класе Osmosmerka_tempejt </a></li>
		</ul>
		<p>Упутство: У форму уписати назив '.txt' документа у ком се налази текст из ког ће се преузети само речи и унети у базу података. Документ се мора налазити у фајлу: "tekstovi_za_popunjavanje_baze_recima" и његов назив мора бити исправно уписан. Пазите које писмо користите приликом уписа назива документа у форму. Тренутно је дозвољен рад само са латиничним писмом, тј. текст у документу мора бити у латиници да би се успешно унелe речи у базу, док ће ћириличне речи прескочити.<p>
		<p1>Напомена: користити ову страницу са опрезом. Прихватањем масовног усноса речи из текст документа може негативно утицати на квалитет направљених осмосмерки. Документ који унесете у форму мора бити на српском језику!</p1>

		<?php
		require_once 'osnova/inicijalizacija.php';
		$korisnik = new Korisnik();
		
		if( !($korisnik->ima_prava('admin')) ){
			Preusmeri::na('pocetna_stranica.php');
		} 

		if (Input::postoji()  ) //file_exists(Input::vrati('dokument'))
		{
			$prvi_deo_puta = "tekstovi_za_popunjavanje_baze_recima/"; 
			$ime_dokumenta = Input::vrati('dokument');

			$extenzija = ".txt";
			$put_dokumenta = $prvi_deo_puta.$ime_dokumenta.$extenzija;
			

			if(!file_exists($put_dokumenta) )
			{
				?> <br><p>Име документа које сте унели не постоји у фајлу 'tekstovi_za_popunjavanje_baze_recima'. Прочитајте поново упутство и пробајте опет.</p><br> <?php
				exit();
			}
			
			// bez praznih elemenata u nizi, bez reci kracih od 5 karaktera (jer ima previse kratkih reci, pa da se izbalansira odnos duzih i kracih reci), 
			// a u validaciji ce da ukloni reci vece od 12
			$niz_svih_reci_dokumenta =  unos_reci_za_osmosmerke_iz_fajla( file_get_contents($put_dokumenta) );

			if (empty($niz_svih_reci_dokumenta)) 
			{
				?> <br><p>Ниједна реч није припремљена за унос. Могући разлози могу бити:</p><br>
					<p1>Документ није .txt формата.</p1>
					<p1>Документ нема никакав текст у себи.</p1>
					<p1>Документ има текст у себи али није сачуван.</p1>
					<p1>Ниједна реч у том тексту није валидна што се може десити ако је текст лоше конвертован из неког другог формата (PDF). Proverite da li je tekst ispravan. </p1>
				<?php
				exit();
			}
			
			// print_r($niz_svih_reci_dokumenta);

			$niz_kriterijum_validacija = array(
					'rec' => array(
						'obavezno' => TRUE,
						'min' => 6,
						'max' => 24, // jer su sva cirilicna slova 2 bajta
						'jedinstven' => 'reci_osmosmerke'
				)
			);

			$broj_unetih_reci = 0;
			$unete_reci = array();
			$neuspele = array();

			for($kljuc_reci = 0; $kljuc_reci < count($niz_svih_reci_dokumenta); $kljuc_reci++ )
			{
				$validacija = new Validacija();
				$rez_validacije = $validacija->provera_unosa($niz_svih_reci_dokumenta[$kljuc_reci], $niz_kriterijum_validacija);

				if($rez_validacije->validacija_uspela())
				{
					$bp_instanca = Baza_podataka::vrati_instancu();
					// unos reci sa imenom dokumenta iz kog je ta rec uneta
					$red_tabele = array('rec'=>$niz_svih_reci_dokumenta[$kljuc_reci]['rec'], 'tip_unosa'=>$ime_dokumenta);
					$bp_instanca->unesi('reci_osmosmerke', $red_tabele);
					$broj_unetih_reci++;
					$unete_reci[] = $niz_svih_reci_dokumenta[$kljuc_reci]['rec'];

				} else 
				{
					$neuspele[$kljuc_reci] = array($niz_svih_reci_dokumenta[$kljuc_reci]['rec'], $rez_validacije->sve_greske() );
				}
			}

			if($broj_unetih_reci)
			{
				echo "<br>". "Број успешно унетих речи је: {$broj_unetih_reci} " . "<br>";
				echo "Унете речи су: " . "<br>";
				foreach ($unete_reci as $key => $value) {
					echo $value . ", ";
				}
					
			} else {
				echo "Ниједна реч није унета у базу!" . "<br>"; 
				echo "Разлози: " . "<br>";
				foreach ($neuspele as $key => $value) {
					print_r( $neuspele[$key] );
				}
				
			}
			
		}

		// https://www.php.net/manual/en/function.file-exists.php 
		// clearstatcache() - komentar
		?>
		
		<h2> Масовни унос речи у табелу за осмосмерку (reci_osmosmerke) </h2>
		<form action="" method="post" >
			<div>
				<label for="dokument">Унесите име документа</label>
				<input type="text" id="dokument" name="dokument" autocomplete="on">
			</div>
			<!-- <input type="radio" name="pismo" value="ћирилица" checked="checked">Текст је у ћирили<br> -->

			<input type="submit" value="Масовно уношење речи у базу података">
		</form> 

	</div>

	<script>
	if ( window.history.replaceState ) 
	{
			window.history.replaceState( null, null, window.location.href );
	}
	</script>
</body>
</html>