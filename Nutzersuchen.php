
<?php
session_start();

if (!isset($_SESSION['userid'])) {
    echo "Bitte zuerst einloggen.";
    echo '<a href="login.php">Bitte einloggen</a>';
}

$db = new Database();
$db->connect();
    
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Nutzer suchen</title>
   <div style="position:absolute; top:10px; right:10px;">
</div>
</head>
<body
     style="background-color:#FFA500;">
  <form action="Nutzersuchen.php" method="get">
    <input type="text" name="name" placeholder="Rezeptname eingeben">
    <button type="submit">Suchen</button>
</form>
<div class="container">
<?php
if (!empty($name)) {
    // Trefferliste
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
