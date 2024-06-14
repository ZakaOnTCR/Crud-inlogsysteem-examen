<?php
// functions.php

// Functie om een nieuwe gebruiker te registreren
function registerUser($conn, $gebruikersnaam, $wachtwoord, $email, $naam)
{
    try {
        // Voorbereiden van het insert statement
        $sql = "INSERT INTO inlog (gebruikersnaam, wachtwoord, email, naam) VALUES (:gebruikersnaam, :wachtwoord, :email, :naam)";
        $stmt = $conn->prepare($sql);

        // Parameters binden 
        $stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
        $stmt->bindParam(':wachtwoord', $wachtwoord); // Hier voegen we het wachtwoord ongehasht toe natuurlijk
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':naam', $naam);

        // hier wordt de Statement uitgevoert
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $exception) {
        echo "Insert error: " . $exception->getMessage();
        return false;
    }
}

// Functie om in te loggen
function loginUser($conn, $email, $wachtwoord)
{
    try {
        // voorbereiden van het select statement om het gehashte wachtwoord van de gebruiker op te halen
        $sql = "SELECT wachtwoord FROM inlog WHERE email = :email";
        $stmt = $conn->prepare($sql);

        // email verbinden met de, parameter 
        $stmt->bindParam(':email', $email);

        // hier wordt de statement uitgevoerd
        $stmt->execute();

        // Controleren of er een gebruiker met het opgegeven emailadres bestaat
        if ($stmt->rowCount() == 1) {
            // haalt de gehashte wachtwoord van de gebruiker op
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashed_password = $row['wachtwoord'];

            // Het opgegeven wachtwoord verifiëren ten opzichte van het gehashte wachtwoord
            if ($wachtwoord === $hashed_password) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } catch (PDOException $exception) {
        echo "Login error: " . $exception->getMessage();
        return false;
    }
}

// Functie om de rol van de gebruiker op te halen uit de database (sql)
function getUserRole($conn, $email) {
    // Logica om de rol van de gebruiker op te halen
    // hieronder een voorbeeld van hoe je dit doet.
    $query = "SELECT rol FROM inlog WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch();
    if ($result) {
        return $result['rol']; // De rol van de gebruiker terug sturen of terwel retourneren.
    } else {
        return false; // hij retourneert'm false als de gebruiker niet is gevonden en of geen rol heeft
    }
}

// Functie om het wachtwoord van de gebruiker op te halen
function getUserPassword($conn, $gebruikerId) {
    try {
        // Query om het huidige wachtwoord op te halen
        $query = "SELECT wachtwoord FROM inlog WHERE inlogid = :gebruikerId";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':gebruikerId', $gebruikerId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['wachtwoord'];
    } catch (PDOException $exception) {
        echo "Password retrieval error: " . $exception->getMessage();
        return false;
    }
}

// Functie om gebruikersgegevens bij te werken
function updateUser($conn, $gebruikerId, $gebruikersnaam, $email, $wachtwoord, $naam, $rol) {
    try {
        // Gebruikersgegevens bijwerken in de database, inclusief het wachtwoord
        $query = "UPDATE inlog SET gebruikersnaam = :gebruikersnaam, email = :email, wachtwoord = :wachtwoord, naam = :naam, rol = :rol WHERE inlogid = :gebruikerId";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':wachtwoord', $wachtwoord); // Voeg het wachtwoord toe als parameter
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':gebruikerId', $gebruikerId);
        $stmt->execute();
        return true; // True retourneren als de update succesvol is
    } catch (PDOException $exception) {
        echo "Update error: " . $exception->getMessage();
        return false; // False retourneren als er een fout optreedt tijdens het uipdaten.
    }
}

// Functie om een nieuwe gebruiker toe te voegen
function addUser($conn, $gebruikersnaam, $email, $wachtwoord, $naam, $rol)
{
    try {
        // Voorbereiden van het insert statement
        $sql = "INSERT INTO inlog (gebruikersnaam, wachtwoord, email, naam, rol) VALUES (:gebruikersnaam, :wachtwoord, :email, :naam, :rol)";
        $stmt = $conn->prepare($sql);

        // Parameters binden
        $stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
        $stmt->bindParam(':wachtwoord', $wachtwoord); // Hier voegen we de aangemaakte wachtwoord ongehasht toe
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':rol', $rol);

        // Statement uitvoeren
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $exception) {
        echo "Insert error: " . $exception->getMessage();
        return false;
    }
}

?>
