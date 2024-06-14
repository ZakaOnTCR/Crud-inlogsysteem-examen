<?php
// dashboard.php

// Include de database script enz
include '../db/database.php';

// Start de sessie om toegang te krijgen tot de content van deze sessie
session_start();

// hier Controleert ie ook gewoon of de gebruiker is ingelogd
if (!isset($_SESSION['email'])) {
    // Als de gebruiker niet is ingelogd, stuur ze dan terug naar de inlogpagina
    header("Location: ../login.html");
    exit();
}

// Controleer of de gebruiker een admin is
if ($_SESSION['rol'] !== 1) {
    // Als de gebruiker geen admin is, stuur ze dan naar de homepagina want dan is het een gebruiker
    header("Location: home.php");
    exit();
}

// pakt de database connectie
$conn = getConnection();

// start een queryy om alle gebruikersggevens op te halen

$query = "SELECT * FROM inlog";
$stmt = $conn->query($query);
$gebruikers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include "../include/header.php" ?>
        <h2>Dashboard</h2>
        <p>Welkom, <?php echo $_SESSION['email']; ?>!</p>
        <p>Dit is het dashboard voor admins.</p>
        <a href="logout.php" class="btn btn-danger">Uitloggen</a>
        <a href="add_user.php" class="btn btn-primary ml-2">Gebruiker toevoegen</a>

        <h3>Gebruikersgegevens</h3>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Gebruikersnaam</th>
                        <th>Email</th>
                        <th>Naam</th>
                        <th>Wachtwoord</th>
                        <th>Rol</th>
                        <th>Actie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gebruikers as $gebruiker): ?>
                        <tr>
                            <td><?php echo $gebruiker['gebruikersnaam']; ?></td>
                            <td><?php echo $gebruiker['email']; ?></td>
                            <td><?php echo $gebruiker['naam']; ?></td>
                            <td><?php echo $gebruiker['wachtwoord']; ?></td> <!-- Wachtwoordkolom toegevoegd -->
                            <td><?php echo $gebruiker['rol'] == 1 ? 'Admin' : 'Gebruiker'; ?></td>
                            <td>
                                <!-- hier ergens bevind de bewerken knop  -->
                                <a href="edit_modal.php?gebruiker_id=<?php echo $gebruiker['inlogid']; ?>" class="btn btn-primary btn-sm mr-2">Bewerken</a>
                                <!-- hier ergens bevind zich de veewijder knop. -->
                                <?php if ($_SESSION['email'] !== $gebruiker['email']): ?> <!-- Controleer of de gebruiker zijn eigen account probeert te verwijderen -->
                                    <form action="delete_user.php" method="post" style="display:inline-block;" onsubmit="return confirm('Weet u zeker dat u deze gebruiker wilt verwijderen?');">
                                        <input type="hidden" name="gebruiker_id" value="<?php echo $gebruiker['inlogid']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Verwijderen</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted">Het Ingelogde account kan niet worden verwijderd.</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include "../include/footer.php" ?>