<?php
// hier start ie de sessie
session_start();

// hier conttrollreert ie of de gebruiker is ingelogd
if (!isset($_SESSION['email'])) {
    //als de gebruiker niet is ingelogd, stuur ze dan terug naar de inlogpagina.
    header("Location: ../login.html");
    exit();
}

?>

<?php include '../include/header.php' ?>
        <h2>Welkom, <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>!</h2>
        <p>Dit is uw profielpagina.</p>
        <a href="logout.php" class="btn btn-danger">Uitloggen</a>
        <a href="edit_profile.php" class="btn btn-primary ml-2">Profiel bewerken</a> 
    </div>

<?php include '../include/footer.php' ?>