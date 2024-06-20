<?php
// update_user.php

// Include the database connection script
include '../db/database.php';

// Include the functions script
include 'functions.php';

// Start de sessie om toegang te krijgen tot sessievariabelen
session_start();

// Contrroleer of de gebruiker is ingelogd
if (!isset($_SESSION['email'])) {
    // Als de gebruiker niet is ingelogd, stuur ze dan terug naar de inlogpagina
    header("Location: ../login.html");
    exit();
}

// Controleer of de gebruiker een admin is
if ($_SESSION['rol'] !== 1) {
    // Als de gebruiker geen admin is, stuur ze dan naar de homepagina
    header("Location: home.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the database connection
    $conn = getConnection();

    // Get the form data
    $gebruikerId = $_POST['gebruiker_id'];
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $email = $_POST['email'];
    $naam = $_POST['naam'];
    $rol = $_POST['rol'];
    $wachtwoord = $_POST['wachtwoord'];
    $herhaal_wachtwoord = $_POST['herhaal_wachtwoord'];

    // Controleer of het wachtwoord veld is ingevuld
    if (!empty($wachtwoord) && $wachtwoord === $herhaal_wachtwoord) {
        // Het wachtwoord is ingevuld en komt overeen, gebruik het nieuwe wachtwoord
        $hashed_wachtwoord = $wachtwoord;
    } else {
        // Het wachtwoord is niet ingevuld of komt niet overeen, gebruik het oude wachtwoord
        $hashed_wachtwoord = getUserPassword($conn, $gebruikerId);
    }

    // Update de gebruiker
    if (updateUser($conn, $gebruikerId, $gebruikersnaam, $email, $hashed_wachtwoord, $naam, $rol)) {
        // Als de update succesvol is, stuur de gebruiker dan terug naar het dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Failed to update user."; // Toon een foutmelding als er een probleem is met updaten
    }
} else {
    echo "Invalid request method."; // Toon een foutmelding als de gebruiker niet via een POST-verzoek is gekomen
}
?>
