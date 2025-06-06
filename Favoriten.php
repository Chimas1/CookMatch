<?php
session_start();
require_once 'db.php'; // Deine DB-Verbindung

// Prüfen, ob der Benutzer angemeldet ist
if (!isset($_SESSION['benutzer_id'])) {
    die("Bitte zuerst einloggen.");
}

$benutzer_id = $_SESSION['benutzer_id'];
$rezept_id = intval($_GET['rezept_id'] ?? 0);

if ($rezept_id > 0) {
    // Prüfen, ob das Rezept schon in den Favoriten ist
    $stmt = $pdo->prepare("SELECT * FROM speichern WHERE benutzer_id = ? AND rezept_id = ?");
    $stmt->execute([$benutzer_id, $rezept_id]);
    if ($stmt->rowCount() == 0) {
        // Hinzufügen
        $stmt = $pdo->prepare("INSERT INTO speichern (benutzer_id, rezept_id) VALUES (?, ?)");
        if ($stmt->execute([$benutzer_id, $rezept_id])) {
            echo "Rezept zu Favoriten hinzugefügt!";
        } else {
            echo "Fehler beim Hinzufügen.";
        }
    } else {
        echo "Rezept ist bereits in den Favoriten!";
    }
} else {
    echo "Ungültige Rezept-ID.";
}
?>
