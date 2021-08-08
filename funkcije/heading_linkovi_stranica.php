<?php

/*
 Funkcija služi da napravi sve heading linkove kako ovaj html ne bi stajao na stranicama.
 u slučaju pravljenja novih stranica, dodati ih odgovarajućim korisnicima, inače neće imati link da im pristupe, tj. moćiće kroz url ako znaju naziv fajla, sto je besmisleno ocekivati dai ko radi.

 INPUT: 
 	- $prava_korisnika - string dobijen od objekta $korisnik iz JSON podatka, tabela "korisnici", kolona "tip_korisnika"
 	- $id_korisnika - trebao bi biti int osim ako ga query pretvara u string, sto cisto sumnjam al sam lenj da pogledam, iz tabele "korisnici"

 RETURN:
 	- string html kod-a stranica sajta za odgovarajući tip korisnika
*/

function napravi_heading($prava_korisnika, $id_korisnika, $id_osm = '')
{
	switch ($prava_korisnika) 
	{


		// ------------------------------------------------------------------------------------------------------------------------------------------------
		// ----------------------------------------------------------OBIČAN KORISNIK HEADING---------------------------------------------------------------
		// ------------------------------------------------------------------------------------------------------------------------------------------------
		case 1:
			return '
				<ul id="stranice">
					<li><a href="index.php?id_osm=' . $id_osm .  '">Почетна страница</a></li>
					<li><a href="igraOsmosmerka.php">Осмосмерка</a></li>
					<li><a href="kvadratna_spl.php">Интерполација</a></li>
					<li><a href="asimetricna_osmosmerka.php">Асиметрична осмосмерка</a></li>
					<div class="dropdown">
						<div class="dropbtn">Korisnik</div>
							<div class="dropdown-content">	
								<a href="profil.php?korisnik=' . $id_korisnika . '">Профил</a> 			
								<a href="azuriranje.php">Промени име</a>
								<a href="promeni_sifru.php">Промени шифру</a>
							</div>
					</div>
				

					<div class="dropdown">
						<div class="dropbtn">Алати за осмосмерке</div>
							<div class="dropdown-content">
								<a href="testiranje_rada_klase_osmosmerka_templejt.php">Интерна умреженост осмосмерке</a> 
								<a href="mat_osm.php">Математика осмосмерке</a>
							</div>
					</div>
					
					<li style="float: right; margin: 0; padding: 0px 5px"><a style="margin: 10px; padding: 5px 10px 5px 5px" href="odjava.php">Одјава</a></li>	
				</ul>
			';
			break;


		// ------------------------------------------------------------------------------------------------------------------------------------------------
		// ----------------------------------------------------------ADMINISTRATOR HEADING-----------------------------------------------------------------
		// ------------------------------------------------------------------------------------------------------------------------------------------------	
		case 2:
			return '
				<ul id="stranice">
					<li><a href="index.php">Почетна страница</a></li>
					<li><a href="igraOsmosmerka.php">Осмосмерка</a></li>
					<li><a href="kvadratna_spl.php">Интерполација</a></li>
					<li><a href="asimetricna_osmosmerka.php">Асиметрична осмосмерка</a></li>
					<div class="dropdown">
						<div class="dropbtn">Korisnik</div>
							<div class="dropdown-content">	
								<a href="profil.php?korisnik=' . $id_korisnika . '">Профил</a> 			
								<a href="azuriranje.php">Промени име</a>
								<a href="promeni_sifru.php">Промени шифру</a>
							</div>
					</div>
				
					<div class="dropdown">
						<div class="dropbtn">Алати за базу</div>
							<div class="dropdown-content">
								<a href="admin_stranica.php">Админ страница</a>						
								<a href="brisanje_reci_sa_neparnim_brojem_karaktera.php">Брисање свих речи са непарним бројем карактера</a>
								<a href="brisanje_reci_sa_latinicnim_karakterom.php">Брисање свих речи са латиничним карактером</a>						
								<a href="glomazni_unos_reci.php">Алат за масовни/гломазни/bulk унос речи у табелу за попуњавање осмосмерки</a>
								<a href="test_tabele_osmosmerke.php">Тест валидности табела за речи (reci_osm_N)</a>
							</div>
					</div>

					<div class="dropdown">
						<div class="dropbtn">Алати за осмосмерке</div>
							<div class="dropdown-content">
								<a href="testiranje_rada_klase_osmosmerka_templejt.php">Алат за тестирање рада класе Osmosmerka_tempejt</a>
								<a href="pravljenje_ogromnih_osmosmerki.php">Страница за прављење огромних осмосмерки</a> 
								<a href="to_do_list.php">to_do_list</a>
								<a href="mat_osm.php">Математика осмосмерке</a>
							</div>
					</div>
					
					<li style="float: right; margin: 0; padding: 0px 5px"><a style="margin: 10px; padding: 5px 10px 5px 5px" href="odjava.php">Одјава</a></li>	
				</ul>
			';
			break;
		
		default:
			exit ("ne postoji korisnik sa ovim pravom pristupa, možda pokušavaš da praviš guest objekat korisnika kome nije definisan nivo privilegije");
			break;
	}
}

?>

