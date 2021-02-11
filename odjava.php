<?php
require_once 'osnova/inicijalizacija.php';

$korisnik = new Korisnik();
$korisnik->odjavi_k();

Preusmeri::na('pocetna_stranica.php');