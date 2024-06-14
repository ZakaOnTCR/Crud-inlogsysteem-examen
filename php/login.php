<?php
// login.php

//database connectie en functies worden include
include '../db/database.php'; 
include 'functions.php';

// checkt of de formulier is verstuurd
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];

    // pak de database connectie op
    $conn = getConnection();

    // loged in de user 
    if (loginUser($conn, $email, $wachtwoord)) {
        // hier haalt ie  de gebruikersrol op uit de database
        $rol = getUserRole($conn, $email);

        // Start een sessie en stelt sessievariabelen in zoals nodig
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['rol'] = $rol;

        // stuurt door  naar een beveiligde pagina op basis van de rol
        if ($rol === 1) {
            header("Location: dashboard.php");
        } else {
            header("Location: home.php");
        }
        exit();
    } else {
        echo "Ongeldige email of wachtwoord.";
    }
} else {
    echo "Ongeldige verzoekmethode.";
}
?>
