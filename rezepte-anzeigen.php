<?php

// Conection herstellen

 require_once 'Database.php';

// Primärschlüssel aus z. B. URL holen
$id = intval($_GET['id']); // immer validieren!

// SQL-Abfrage vorbereiten
$db = new Database();
$db->connect();
$result = $db->preparedStm("SELECT * FROM Rezepte WHERE id = ?", "i", $id);
$result = $result->fetch_assoc();

// Datensatz ausgeben
if ($row = $result->fetch_assoc()) {
    echo "Rezeptname: " . htmlspecialchars($row['Name']) . "<br>";
    echo "Beschreibung: " . htmlspecialchars($row['Beschreibung']) . "<br>";
    // Weitere Felder...
} else {
    echo "Kein Rezept gefunden.";
}



// Conection schließen

$conn->close();
?>
