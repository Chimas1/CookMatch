<?php
require_once 'Database.php';
$db = new Database();
$conn = $db->connect();
$rezeptname ="";

if (isset($_GET['rezeptname'])) {
    $suchbegriff = $conn->real_escape_string($_GET['rezeptname']);
    
    $sql = "SELECT name FROM Rezept WHERE name LIKE '%$rezeptname%'";
    $result = $conn->query($sql);
} 
$db->disconnect();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Suche</title>
   <div style="position:absolute; top:10px; right:10px;">
</div>
</head>
<body
     style="background-color:#FFA500;">
    <form method="get" action="rezept-suchen.php">
        <input type="text" name="suchbegriff" value="<?php echo htmlspecialchars($suchbegriff); ?>" placeholder="Rezeptname eingeben">
        <button type="submit">Suchen</button>
    </form>
<h2>Suchergebnisse:</h2>
    <?php if (isset($_GET['Rezeptname'])): ?>
            <?php if ($result->num_rows > 0): ?>
            <ul>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li> Name: <?php echo htmlspecialchars($row['name']); ?></li>
    <?php endwhile; ?>        
                </ul>
        <?php else: ?>
            <p>Keine Rezept unter dem Namen gefunden.</p>
        <?php endif; ?>
    <?php endif; ?>
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
    <option value="italienisch">Italienisch</option>
    <option value="deutsch">Deutsch</option>
    <option value="asiatisch">Asiatisch</option>
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
    <option value="dessert">Dessert</option>
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
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rezepte = $stmt->fetchAll();

        
