<?php
session_start();

$GLOBALS['niz_konfiguracija'] = array(
	'mysql' => array (
		'domacin' => "127.0.0.1", 
		'korisnicko_ime_bp' => "root",
		'sifra_bp' => "",
		'baza_podataka' => "baza_podataka_osmosmerka1"
	),
	'zapamti_me' => array(
		'ime_kolacica' => 'hes',
		'kolacic_istice' => 604800 // U sekundama = 7 dana
	),
	'sesija' => array(
		'ime_sesije' => 'korisnik',
		'ime_tokena' => 'token' 
	)
);

// -----------------------------------------------------Ucitavanje fajlova------------------------------------------------
spl_autoload_register(function($klasa){
	require_once 'klase/' . $klasa . '.php';
});


require_once 'funkcije/ocisti.php'; 
require_once 'funkcije/sortiranje_niza.php';
require_once 'funkcije/funkcija_donja_crta.php';
require_once 'funkcije/da_li_rec_postoji_u_osmosmerci.php';
require_once 'funkcije/funckija_napravi_tabelu.php';
require_once 'funkcije/reci_sa_latinicnim_slovom.php';
require_once 'funkcije/reci_sa_neparnim_br_karaktera.php';
require_once 'funkcije/rec_ima_karakter_u_sebi.php';
require_once 'funkcije/lat_u_cir.php';
require_once 'funkcije/prikaz_duzina_puta.php';
require_once 'funkcije/unos_reci_za_osmosmerke_iz_fajla.php';

// za numericku matematiku
require_once 'testovi_soritanja_po_metodama_numericke_analize\gaus_jordan_metoda_eliminacije_pokusaj_2.php';
require_once 'testovi_soritanja_po_metodama_numericke_analize\sortiranje_po_glavnoj_dijagonali.php';
require_once 'testovi_soritanja_po_metodama_numericke_analize\formiranje_matrice.php';

//------------------------------------------------------------------------------------------------------------------------
// var_dump(Kolacic::kolacic_postoji(Konfiguracija::vrati_konf('zapamti_me/ime_kolacica')));
// var_dump(Konfiguracija::vrati_konf('zapamti_me/ime_kolacica'));
// var_dump(Sesija::postoji(Konfiguracija::vrati_konf('sesija/ime_sesije')));
if(Kolacic::kolacic_postoji(Konfiguracija::vrati_konf('zapamti_me/ime_kolacica')) AND !Sesija::postoji(Konfiguracija::vrati_konf('sesija/ime_sesije')))
{
	$hes_ = Kolacic::kolacic_vrati(Konfiguracija::vrati_konf('zapamti_me/ime_kolacica'));
	$hes_provera = Baza_podataka::vrati_instancu()->pronadji('sesije_korisnika', array('t_hes', '=', $hes_));

	if($hes_provera->br_redova())
	{
		$korisnik = new Korisnik($hes_provera->prvi_rez()->id_korisnika);
		$korisnik->prijavi_k();
	}
}