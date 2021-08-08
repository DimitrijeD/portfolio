<?php
session_start();

// local conn

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
 

// ------------------------------------------------------------Remote sql conn --------------------------------------------------
/*
$GLOBALS['niz_konfiguracija'] = array(
	'mysql' => array (
		'domacin' => "remotemysql.com",  // host
		'korisnicko_ime_bp' => "dcvmGS6q3i",
		'sifra_bp' => "EpLgXLKBif",
		'baza_podataka' => "dcvmGS6q3i"
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
*/
/*
// https://www.phpmyadmin.co/index.php
// https://www.freemysqlhosting.net/account/
// https://mail.google.com/mail/u/0/#inbox/FMfcgzGkZQHdXSzSVCkCNhxnBhsCCJfr
$GLOBALS['niz_konfiguracija'] = array(
	'mysql' => array (
		'domacin' => "sql11.freemysqlhosting.net",  // host
		'korisnicko_ime_bp' => "sql11424945",
		'sifra_bp' => "BxLErvzRHc",
		'baza_podataka' => "sql11424945"
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
*/
// -----------------------------------------------------Ucitavanje fajlova------------------------------------------------
spl_autoload_register(function($klasa){
	require_once 'klase/' . $klasa . '.php';
});

// PHP FUNKCIJE
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
require_once 'funkcije/resenje_osmosmerke.php';
require_once 'funkcije/napravi_spisak_reci_za_pronalazenje_u_osm.php';
require_once 'funkcije/obradi_asim_polja.php';
require_once 'funkcije/asm_uklanjanje_polja.php';
require_once 'funkcije/da_li_je_sav_str_latinicni.php';
require_once 'funkcije/da_li_je_sav_str_cirilicni.php';
require_once 'funkcije/formiraj_osmosmerku_iz_baze.php'; 
require_once 'funkcije/heading_linkovi_stranica.php';
require_once 'funkcije/cir_u_lat.php';

// otvori sve nizove pisama / zauzima memoriju nepotrebno ali šta je tu je
require_once 'nizovi_slova_pisama/nizovi_slova_pisama.php';

// za numericku matematiku
require_once 'funkcije_interpolacije/gaus_jordan_metoda_eliminacije_pokusaj_2.php';
require_once 'funkcije_interpolacije/sortiranje_po_glavnoj_dijagonali.php';
require_once 'funkcije_interpolacije/formiranje_matrice.php';

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