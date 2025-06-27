<?php
require_once 'Database.php';

$db = new Database();
$conn = $db->connect();

$name = isset($_GET['name']) ? $_GET['name'] : '';
$rezeptDetails = null;
$suchErgebnisse = null;

if (!empty($name)) {
    // Alle Rezepte suchen, die ähnlich heißen
    $name_esc = $conn->real_escape_string($name);
    $sql = "SELECT name FROM Rezept WHERE name LIKE '%$name_esc%'";
    $suchErgebnisse = $conn->query($sql);

    // Prüfen, ob ein exakt passendes Rezept existiert
    $sqlDetail = "SELECT * FROM Rezept WHERE name = '$name_esc'";
    $detailsRes = $conn->query($sqlDetail);
    if ($detailsRes && $detailsRes->num_rows === 1) {
        $rezeptDetails = $detailsRes->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Rezepte suchen</title>
   <div style="position:absolute; top:10px; right:10px;">
</div>
</head>
<body
     style="background-color:#FFA500;">
  <form action="rezepte-anzeigen.php" method="get">
    <input type="text" name="name" placeholder="Rezeptname eingeben">
    <button type="submit">Suchen</button>
</form>
<div class="container">
<?php
if (!empty($name)) {
    // Detailansicht bei exaktem Treffer
    if ($rezeptDetails) {
        echo '<h2>' . htmlspecialchars($rezeptDetails['name']) . '</h2>';
        // ... Details hier anzeigen ...
    }
    // Trefferliste bei unscharfer Suche
    elseif ($suchErgebnisse && $suchErgebnisse->num_rows > 0) {
        echo '<h2>Suchergebnisse:</h2><ul>';
        while ($row = $suchErgebnisse->fetch_assoc()) {
            echo '<li><a href="rezepte-anzeigen.php?name=' . urlencode($row['name']) . '">' . htmlspecialchars($row['name']) . '</a></li>';
        }
        echo '</ul>';
    }
    // Kein Treffer
    else {
        echo '<p>Kein Rezept unter diesem Namen gefunden.</p>';
    }
}
?>
</div>
</body>
</html>




<form method="get" action="">
  <!-- Zutaten -->
  <label>Zutaten:</label>
  <input type="text" name="zutaten" placeholder="z.B. Tomate, Zwiebel"><br>

  <!-- Kulinarische Herkunft -->
  <label>Kulinarische Herkunft:</label>
  <select name="herkunft">
    <option value="">Alle</option>
    <option value="italien">Italien</option>
    <option value="usa">Usa</option>
    <option value="europa">Europa</option>
    <option value="regional">Regional</option>
    <!-- ...Erweitern nach Bedarf -->
  </select><br>

  <!-- Zeit -->
  <label>Max. Zeit (Minuten):</label>
  <input type="number" name="zeit" min="1"><br>

  <!-- Schwierigkeit -->
  <label>Schwierigkeit:</label>
  <select name="schwierigkeit">
    <option value="">Alle</option>
    <option value="leicht">Leicht</option>
    <option value="mittel">Mittel</option>
    <option value="schwer">Schwer</option>
  </select><br>

  <!-- Bewertung -->
  <label>Min. Bewertung (1-5):</label>
  <input type="number" name="bewertung" min="1" max="5"><br>

  <!-- Gang -->
  <label>Gang:</label>
  <select name="gang">
    <option value="">Alle</option>
    <option value="vorspeise">Vorspeise</option>
    <option value="hauptspeise">Hauptspeise</option>
    <option value="nachspeise">Nachspeise</option>
    <!-- ...Erweitern nach Bedarf -->
  </select><br>

  <!-- Ersteller -->
  <label>Ersteller:</label>
  <input type="text" name="ersteller" placeholder="Username"><br>

  <!-- Vegan/Vegetarisch -->
  <label>
    <input type="checkbox" name="vegan" value="1"> Vegan
  </label>
  <label>
    <input type="checkbox" name="vegetarisch" value="1"> Vegetarisch
  </label><br>

  <input type="submit" value="Filtern">
</form>

<?php
$where = [];
$params = [];

// Zutaten (nur wenn ausgefüllt)
if (!empty($_GET['zutaten'])) {
    $zutaten = explode(',', $_GET['zutaten']);
    foreach ($zutaten as $zutat) {
        $where[] = "zutaten LIKE ?";
        $params[] = '%' . trim($zutat) . '%';
    }
}

// Kulinarische Herkunft
if (!empty($_GET['herkunft'])) {
    $where[] = "herkunft = ?";
    $params[] = $_GET['herkunft'];
}

// Zeit
if (!empty($_GET['zeit'])) {
    $where[] = "zeit <= ?";
    $params[] = (int)$_GET['zeit'];
}

// Schwierigkeit
if (!empty($_GET['schwierigkeit'])) {
    $where[] = "schwierigkeit = ?";
    $params[] = $_GET['schwierigkeit'];
}

// Bewertung
if (!empty($_GET['bewertung'])) {
    $where[] = "bewertung >= ?";
    $params[] = (int)$_GET['bewertung'];
}

// Gang
if (!empty($_GET['gang'])) {
    $where[] = "gang = ?";
    $params[] = $_GET['gang'];
}

// Ersteller
if (!empty($_GET['ersteller'])) {
    $where[] = "ersteller = ?";
    $params[] = $_GET['ersteller'];
}

// Vegan/Vegetarisch
if (!empty($_GET['vegan'])) {
    $where[] = "vegan = 1";
}
if (!empty($_GET['vegetarisch'])) {
    $where[] = "vegetarisch = 1";
}

// SQL Query zusammensetzen
$sql = "SELECT * FROM rezepte";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

// DB-Abfrage (Beispiel mit PDO)
//$stmt = $pdo->prepare($sql);
//$stmt->execute($params);
//$rezepte = $stmt->fetchAll();
?>
        
