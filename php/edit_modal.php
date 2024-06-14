<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bewerk gebruiker</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Bewerk gebruiker</h2>
        <?php
        //  include de database connectie scriptt
        include '../db/database.php';

        // pakt de gebruikers id uit de url
        $gebruiker_id = $_GET['gebruiker_id'];

        // pakt de database connectie
        $conn = getConnection();

        // Query om de  user data te gebruiken van de gebruiker_id
        $query = "SELECT * FROM inlog WHERE inlogid = :gebruiker_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':gebruiker_id', $gebruiker_id);
        $stmt->execute();
        $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <form action="update_user.php" method="post">
            <input type="hidden" name="gebruiker_id" value="<?php echo $gebruiker['inlogid']; ?>">
            <div class="form-group">
                <label for="gebruikersnaam">Gebruikersnaam</label>
                <input type="text" class="form-control" id="gebruikersnaam" name="gebruikersnaam" value="<?php echo $gebruiker['gebruikersnaam']; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $gebruiker['email']; ?>">
            </div>
            <div class="form-group">
                <label for="wachtwoord">Nieuw wachtwoord</label>
                <input type="password" class="form-control" id="wachtwoord" name="wachtwoord">
            </div>
            <div class="form-group">
                <label for="herhaal_wachtwoord">Herhaal nieuw wachtwoord</label>
                <input type="password" class="form-control" id="herhaal_wachtwoord" name="herhaal_wachtwoord">
            </div>
            <div class="form-group">
                <label for="naam">Naam</label>
                <input type="text" class="form-control" id="naam" name="naam" value="<?php echo $gebruiker['naam']; ?>">
            </div>
            <div class="form-group">
                <label for="rol">Rol</label>
                <select class="form-control" id="rol" name="rol">
                    <option value="1" <?php echo $gebruiker['rol'] == 1 ? 'selected' : ''; ?>>Admin</option>
                    <option value="0" <?php echo $gebruiker['rol'] == 0 ? 'selected' : ''; ?>>Gebruiker</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Opslaan</button>
        </form>
    </div>
</body>
</html>

