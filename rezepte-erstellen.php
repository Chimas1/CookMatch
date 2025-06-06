<?php
session_start();
require_once 'db.php'; // Deine DB-Verbindung

// Prüfen, ob der Benutzer angemeldet ist
if (!isset($_SESSION['userid'])) {
    die("Bitte zuerst einloggen.");
}
  
?>
