<?php
require_once 'osnova/inicijalizacija.php';

$korisnik = new Korisnik();
$korisnik->odjavi_k();
Sesija::obrisi('home');
Preusmeri::na('index.php');

?>