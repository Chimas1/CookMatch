<?php

// Conection herstellen

 require_once 'Database.php';

// Primärschlüssel aus z. B. URL holen
$id = intval($_GET['id']); // immer validieren!

// SQL-Abfrage vorbereiten
$db = new Database();
$db->connect();
$result = $db->select("SELECT * FROM Rezept WHERE id = ?", "i", $id);
$result = $result->fetch_assoc();

// Rezept-Grunddaten
$rezept = $db->select("SELECT * FROM Rezept WHERE id = ?", "i", $id);
if ($row = $rezept->fetch_assoc()) {
    echo "<h2>" . htmlspecialchars($row['Name']) . "</h2>";
    echo "<p>" . htmlspecialchars($row['Beschreibung']) . "</p>";
    echo "<p>Zubereitungszeit: " . htmlspecialchars($row['Zeit']) . " Minuten</p>";
    
    // Zutatenliste
    $zutaten = $db->select("SELECT * FROM Lebensmitteln WHERE rezept_id = ?", "i", $id);
    echo "<h3>Zutaten:</h3><ul>";
    while ($z = $zutaten->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($z['Menge']) . " " . htmlspecialchars($z['Einheit']) . " " . htmlspecialchars($z['Zutat']) . "</li>";
    }
    echo "</ul>";

    // Kochutensilien
    $utensilien = $db->select("SELECT * FROM Kochutensilien WHERE rezept_id = ?", "i", $id);
    echo "<h3>Kochutensilien:</h3><ul>";
    while ($u = $utensilien->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($u['Utensil']) . "</li>";
    }
    echo "</ul>";

 // Anweisungen
    $anweisungen = $db->select("SELECT * FROM Anweisung WHERE rezept_id = ? ORDER BY schritt_nr ASC", "i", $id);
    echo "<h3>Anweisungen:</h3><ol>";
    while ($a = $anweisungen->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($a['Text']) . "</li>";
    }
    echo "</ol>";

    // Bewertungen
    $bewertungen = $db->select("SELECT * FROM bewertet WHERE rezept_id = ?", "i", $id);
    echo "<h3>Bewertungen:</h3>";
    $anzahl = 0; $summe = 0;
    while ($b = $bewertungen->fetch_assoc()) {
        $anzahl++;
        $summe += $b['Sterne'];
        echo "<div>" . htmlspecialchars($b['Benutzer']) . ": " . htmlspecialchars($b['Sterne']) . " Sterne - " . htmlspecialchars($b['Kommentar']) . "</div>";
    }
    if ($anzahl > 0) {
        $schnitt = round($summe / $anzahl, 2);
        echo "<p>Durchschnitt: $schnitt Sterne</p>";
    } else {
        echo "<p>Keine Bewertungen vorhanden.</p>";
    }
} else {
    echo "Kein Rezept gefunden.";
}



// Conection schließen

$conn->close();
?>
