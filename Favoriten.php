<?php
session_start();
require_once 'db.php'; // Deine DB-Verbindung

// Prüfen, ob der Benutzer angemeldet ist
if (!isset($_SESSION['userid'])) {
    echo "Bitte zuerst einloggen.";
    echo '<a href="login.php">Bitte einloggen</a>';

}

$benutzername = $_SESSION['benutzername'];
$name = intval($_GET['name'] ?? 0);

if ($rezept_id > 0) {
    // Prüfen, ob das Rezept schon in den Favoriten ist
    $stmt = $pdo->prepare("SELECT * FROM speichern WHERE benutzername = ? AND name = ?");
    $stmt->execute([$benutzer_id, $rezept_id]);
    if ($stmt->rowCount() == 0) {
        // Hinzufügen
        $stmt = $pdo->prepare("INSERT INTO speichern (benutzername, name) VALUES (?, ?)");
        if ($stmt->execute([$benutzername, $name])) {
            echo "Rezept zu Favoriten hinzugefügt!";
        } else {
            echo "Fehler beim Hinzufügen.";
        }
    } else {
        echo "Rezept ist bereits in den Favoriten!";
    }
} else {
    echo "Ungültiger Rezeptname.";
}
?>
