<?php
// database.php

function getConnection() {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=inlogdb", "root", "");
        // Zet de PDO-error-modus naar 'exception' zodat we uitzonderingen kunnen afhandelen.
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>
