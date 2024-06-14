<?php
// delete_user.php

// pakt de database connectie script
include '../db/database.php';

// Start de sessie om toegang te krijgen tot sessievariabelen
session_start();

// hier Controleert ie ook gewoon of de gebruiker is ingelogd
if (!isset($_SESSION['email'])) {
    // Als de gebruiker niet is ingelogd, dat ie ze dan terugstuurd naar de inlogpagina
    header("Location: ../login.html");
    exit();
}

// Controleert of de gebruiker uberhaubpt wel een admin is
if ($_SESSION['rol'] !== 1) {
    // Als de gebruiker geen admin is, stuur ze dan per directt naar de homepagina
    header("Location: home.php");
    exit();
}

//  hij checkt of de form is gesubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //  pakt de user id van de form 
    $gebruikerId = $_POST['gebruiker_id'];

    // krijgt de database connectie
    $conn = getConnection();

    // verwijdert de user
    $query = "DELETE FROM inlog WHERE inlogid = :gebruikerId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':gebruikerId', $gebruikerId);

    if ($stmt->execute()) {
        // Als de verwijdering succesvol is, stuur de gebruiker dan terug naar het dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Failed to delete user."; // Toont een foutmelding als er een probleem is met verwijderen
    }
} else {
    echo "Invalid request method."; // Toont een foutmelding als de gebruiker niet via een POST-verzoek is gekomen :)
}
?>
