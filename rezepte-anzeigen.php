<?php

// Conection herstellen

 require_once 'Database.php';

// Primärschlüssel aus z. B. URL holen
$id = intval($_GET['Name']); // immer validieren!

// SQL-Abfrage vorbereiten
$db = new Database();
$db->connect();
$result = $db->select("SELECT * FROM Rezept WHERE Name = ?", "s", $id);
$result = $result->fetch_assoc();

// Rezept-Grunddaten
$rezept = $db->select("SELECT * FROM Rezept, Anweisung WHERE name.rezept = name.anweisung Name = ?", "s", $id);
if ($row = $rezept->fetch_assoc()) {
    echo "<h2>" . htmlspecialchars($row['Name']) . "</h2>";
    echo "<p>" . htmlspecialchars($row['Beschreibung']) . "</p>";
    echo "<p>Zubereitungszeit: " . htmlspecialchars($row['Zeit']) . " Minuten</p>";
    
    // Zutatenliste
    $zutaten = $db->select("SELECT * FROM Lebensmittel, enthält, anweisung,rezept WHERE Bezeichnung.lebensmittel=Bezeichnung.enthäl and ID.enthält=ID.anweisung and Name.anweisung= Name.Rezept and name = ?", "i", $id);
    echo "<h3>Zutaten:</h3><ul>";
    while ($z = $zutaten->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($z['Menge']) . " " . htmlspecialchars($z['Einheit']) . " " . htmlspecialchars($z['Zutat']) . "</li>";
    }
    echo "</ul>";

    // Kochutensilien
    $utensilien = $db->select("SELECT * FROM Kochutensilien, braucht, Anweisung, Rezept WHERE Titel.kochutensilien=Titel.braucht and ID.braucht=ID.Anweisung and Name.Anweisung=Name.Rezept and name = ?", "i", $id);
    echo "<h3>Kochutensilien:</h3><ul>";
    while ($u = $utensilien->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($u['Utensil']) . "</li>";
    }
    echo "</ul>";

 // Anweisungen
    $anweisungen = $db->select("SELECT * FROM Anweisung, Rezept WHERE Name.anweisung=Name.Rezept and name= ? ORDER BY schritt_nr ASC", "i", $id);
    echo "<h3>Anweisungen:</h3><ol>";
    while ($a = $anweisungen->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($a['Text']) . "</li>";
    }
    echo "</ol>";

    // Bewertungen
    $bewertungen = $db->select("SELECT * FROM bewertet, Rezepte WHERE Name.bewertet=Name.Rezept and name= ?", "i", $id);
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
