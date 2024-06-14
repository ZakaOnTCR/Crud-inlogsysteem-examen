<?php
// edit_profile.php

// plaats de database connectie script
include '../db/database.php';

// Start de sessie om toegang te krijgen tot sessievariabelen
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['email'])) {
    // Als de gebruiker niet is ingelogd, stuur ze dan terug naar de inlogpagina
    header("Location: ../login.html");
    exit();
}

// Get the database connection
$conn = getConnection();

// Query om gebruikersgegevens op te halen op basis van de ingelogde gebruiker
$query = "SELECT * FROM inlog WHERE email = :email";
$stmt = $conn->prepare($query);
$stmt->bindParam(':email', $_SESSION['email']);
$stmt->execute();
$gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

// Check of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ontvang en verwerk de formuliergegevens
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $email = $_POST['email'];
    $naam = $_POST['naam'];
    $nieuw_wachtwoord = $_POST['nieuw_wachtwoord'];

    // Hash het nieuwe wachtwoord
    $hashed_nieuw_wachtwoord = password_hash($nieuw_wachtwoord, PASSWORD_DEFAULT);

    // Query om gebruikersgegevens bij te werken, inclusief wachtwoord als het is ingevuld natuurlijk
    $updateQuery = "UPDATE inlog SET gebruikersnaam = :gebruikersnaam, email = :email, naam = :naam";
    if (!empty($nieuw_wachtwoord)) {
        $updateQuery .= ", wachtwoord = :wachtwoord";
    }
    $updateQuery .= " WHERE email = :huidige_email";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bindParam(':gebruikersnaam', $gebruikersnaam);
    $updateStmt->bindParam(':email', $email);
    $updateStmt->bindParam(':naam', $naam);
    if (!empty($nieuw_wachtwoord)) {
        $updateStmt->bindParam(':wachtwoord', $hashed_nieuw_wachtwoord);
    }
    $updateStmt->bindParam(':huidige_email', $_SESSION['email']);

    if ($updateStmt->execute()) {
        // Als het bijwerken succesvol is, stuur de gebruiker dan terug naar de homepagina
        header("Location: home.php");
        exit();
    } else {
        echo "Er is een fout opgetreden bij het bijwerken van uw profiel.";
    }
}
?>


<?php include '../include/header.php' ?>
        <h2>Profiel bewerken</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="gebruikersnaam">Gebruikersnaam</label>
                <input type="text" class="form-control" id="gebruikersnaam" name="gebruikersnaam" value="<?php echo isset($gebruiker['gebruikersnaam']) ? $gebruiker['gebruikersnaam'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($gebruiker['email']) ? $gebruiker['email'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="naam">Naam</label>
                <input type="text" class="form-control" id="naam" name="naam" value="<?php echo isset($gebruiker['naam']) ? $gebruiker['naam'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="nieuw_wachtwoord">Nieuw Wachtwoord</label>
                <input type="password" class="form-control" id="nieuw_wachtwoord" name="nieuw_wachtwoord">
            </div>
            <button type="submit" class="btn btn-primary">Opslaan</button>
        </form>
    </div>

<?php include '../include/footer.php' ?>