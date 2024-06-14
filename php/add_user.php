<?php
// add_user.php

// Include the database connection script
include '../db/database.php';
// Include the functions script
include 'functions.php';

// Start de sessie om toegang te krijgen tot sessievariabelen
session_start();

// Controleer of de gebruiker is ingelogd
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

// kijken of de form wel goed  is verzondeeeeeeeeeeeeeeeeeen
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // krijg database connectie
    $conn = getConnection();

    // krijg formulier data
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];
    $herhaal_wachtwoord = $_POST['herhaal_wachtwoord'];
    $naam = $_POST['naam'];
    $rol = $_POST['rol'];

    // hier Controleert ie gwn of het wachtwoord veld is ingevuld en of de wachtwoorden overeenkomen
    if (!empty($wachtwoord) && $wachtwoord === $herhaal_wachtwoord) {
        // de wachtwoorden komen overreen, dus gebruik de ingevulde wachtwoord
        $hashed_wachtwoord = $wachtwoord;

        // Voeg de gebruiker toe aan de database
        if (addUser($conn, $gebruikersnaam, $email, $hashed_wachtwoord, $naam, $rol)) {
            // Als het toevoegen succesvol is gebeurt , stuur de gebruiker dan lekker terug naar het dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Failed to add user."; // toont een foutmelding als er een probleem is met toevioegen
        }
    } else {
        echo "Passwords do not match."; // Toon een foutmelding als de wachtwoorden niet overeenkomen
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruiker toevoegen</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Gebruiker toevoegen</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="gebruikersnaam">Gebruikersnaam</label>
                <input type="text" class="form-control" id="gebruikersnaam" name="gebruikersnaam">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="wachtwoord">Wachtwoord</label>
                <input type="password" class="form-control" id="wachtwoord" name="wachtwoord">
            </div>
            <div class="form-group">
                <label for="herhaal_wachtwoord">Herhaal wachtwoord</label>
                <input type="password" class="form-control" id="herhaal_wachtwoord" name="herhaal_wachtwoord">
            </div>
            <div class="form-group">
                <label for="naam">Naam</label>
                <input type="text" class="form-control" id="naam" name="naam">
            </div>
            <div class="form-group">
                <label for="rol">Rol</label>
                <select class="form-control" id="rol" name="rol">
                    <option value="1">Admin</option>
                    <option value="0">Gebruiker</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Opslaan</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
