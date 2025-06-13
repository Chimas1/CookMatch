<?php

// Conection herstellen

 require_once 'Database.php';

// Primärschlüssel aus z. B. URL holen
$id = htmlspecialchars($_GET['Name']); // immer validieren!
// SQL-Abfrage vorbereiten
$db = new Database();
$db->connect();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Rezepte anzeigen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f9; margin: 0; }
        .container { max-width: 700px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);}
        .rezept-title { font-size: 2em; font-weight: bold; margin-bottom: 10px; color: #35729b;}
        .rezept-img { width: 100%; max-height: 320px; object-fit: cover; border-radius: 8px; margin-bottom: 18px;}
        .meta { color: #888; font-size: 0.95em; margin-bottom: 18px;}
        .section-title { font-size: 1.2em; margin-top: 20px; margin-bottom: 8px; color: #35729b;}
        ul, ol { margin: 0 0 18px 20px; }
        .zutaten { background: #eaf6fd; padding: 12px; border-radius: 8px;}
        .anleitung { background: #fdf3e7; padding: 12px; border-radius: 8px;}
    </style>
</head>
<body>
    <div class="container">
<?php
// Rezept-Grunddaten
$zeit = $db->select("SELECT SUM(Zeit) FROM Rezept, Anweisung WHERE Rezept.Name = Anweisung.Name and Rezept.Name = ?", "s", $id)->fetch_assoc();

$rezept = $db->select("SELECT * FROM Rezept, Anweisung WHERE Rezept.Name = Anweisung.Name and Rezept.Name = ?", "s", $id);
if ($row = $rezept->fetch_assoc()) {
    echo "<div class='rezept-title'>". htmlspecialchars($row['Name']) ."</div>";
    echo "<div class='meta'>Vorbereitungszeit: ".$zeit['SUM(Zeit)'] === null ? 0 : htmlspecialchars($zeit['SUM(Zeit)'])." Min</div>";
    echo "<p>" . htmlspecialchars($row['Beschreibung']) . "</p>";
    
    // Zutatenliste
    $zutaten = $db->select("SELECT * FROM Lebensmittel, Enthält, Anweisung,Rezept WHERE Lebensmittel.Bezeichnung=Enthält.Bezeichnung and Enthält.ID=Anweisung.ID and Anweisung.Name= Rezept.Name and Rezept.Name = ?", "s", $id);
    echo "<h3>Zutaten:</h3><ul>"; 
   echo "<div class='section-title'>Zutaten</div>
        <ul class='zutaten'>";

    while ($z = $zutaten->fetch_assoc()) {
     if (isset($_POST['Zutat'])) {
    $zutat = $_POST['Zutat'];
    // use $zutat here
} else {
    // handle the case when 'Zutat' is not set
    $zutat = null; // or a default value
}
        echo "<li>" . htmlspecialchars($z['Menge']) . " " . htmlspecialchars($z['Einheit']) . " " . htmlspecialchars($z['Zutat']) . "</li>";
    }
    echo "</ul>";

    // Kochutensilien
    $utensilien = $db->select("SELECT * FROM Kochutensilien, Braucht, Anweisung, Rezept WHERE Kochutensilien.Titel=Braucht.Titel and Braucht.ID=Anweisung.ID and Anweisung.Name=Rezept.Name and Rezept.Name = ?", "s", $id);
    echo "<h3>Kochutensilien:</h3><ul>";
    while ($u = $utensilien->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($u['Utensil']) . "</li>";
    }
    echo "</ul>";

 // Anweisungen
   echo "<div class='section-title'>Zubereitung</div>";
    $anweisungen = $db->select("SELECT * FROM Anweisung, Rezept WHERE Anweisung.Name=Rezept.Name and Rezept.Name= ? ORDER BY Anweisung.ID", "s", $id);
    echo "<ol class= '<h3>Anweisungen:</h3><ol>'";
    while ($a = $anweisungen->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($a['Text']) . "</li>";
    }
    echo "</ol>";

    // Bewertungen
    $bewertungen = $db->select("SELECT * FROM Bewertet, Rezept WHERE Bewertet.Name=Rezept.Name and Rezept.Name= ?", "s", $id);
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

$db-> disconnect();
?>
    </div>
</body>
</html>
