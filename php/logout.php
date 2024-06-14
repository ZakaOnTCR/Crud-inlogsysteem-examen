<?php
// Start de sessie om toegang te krijgen tot sessievariabelen
session_start();

// Maak alle sessievariabelen leeg
$_SESSION = array();

// stopt de hele sessie
session_destroy();

// Stuur de gebruiker terug naar de inlogpagina
header("Location: ../login.html"); 
exit();
?>
