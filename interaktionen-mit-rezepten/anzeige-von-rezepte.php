<?php

// Conection herstellen

 require_once 'Database.php';

// Primärschlüssel aus z. B. URL holen
$id = intval($_GET['id']); // immer validieren!

// SQL-Abfrage vorbereiten
$sql = "SELECT * FROM rezepte WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Datensatz ausgeben
if ($row = $result->fetch_assoc()) {
    echo "Rezeptname: " . htmlspecialchars($row['name']) . "<br>";
    echo "Beschreibung: " . htmlspecialchars($row['beschreibung']) . "<br>";
    // Weitere Felder...
} else {
    echo "Kein Rezept gefunden.";
}



// Conection schließen

$conn->close();
?>
