<?php
// Include the database connection and functions
include '../db/database.php'; 
include 'functions.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord =  $_POST['wachtwoord']; // Hash the password
    $email = $_POST['email'];
    $naam = $_POST['naam'];

    // Get the database connection
    $conn = getConnection();

    // Register the user
    if (registerUser($conn, $gebruikersnaam, $wachtwoord, $email, $naam)) {
        // Redirect to login page after successful registration
        header("Location: ../login.html"); 
        exit();
    } else {
        echo "Failed to register user.";
    }
} else {
    echo "Invalid request method.";
}

?>
