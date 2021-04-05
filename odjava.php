<?php
require_once 'osnova/inicijalizacija.php';

$korisnik = new Korisnik();
$korisnik->odjavi_k();
Sesija::obrisi('home');
Preusmeri::na('pocetna_stranica.php');

?>