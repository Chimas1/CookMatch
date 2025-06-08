<?php
require_once 'Database.php';
$db = new Database();
$conn = $db->connect();
$suchbegriff ="";

session_start();
if (!isset($_SESSION['username'])) {
    // Benutzer ist nicht angemeldet, zur Anmeldung weiterleiten
    header("Location: nutzer_login.php");
    exit;
}
echo "Willkommen, " . htmlspecialchars($_SESSION['username']);

if (isset($_GET['suchbegriff'])) {
    $suchbegriff = $conn->real_escape_string($_GET['suchbegriff']);
    
    $sql = "SELECT name FROM Rezept WHERE name LIKE '%$suchbegriff%'";
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
<body>
    <form method="get" action="rezept-suchen.php">
        <input type="text" name="suchbegriff" value="<?php echo htmlspecialchars($suchbegriff); ?>" placeholder="Suchbegriff eingeben">
        <button type="submit">Suchen</button>
    </form>
<h2>Suchergebnisse:</h2>
    <?php if (isset($_GET['suchbegriff'])): ?>
            <?php if ($result->num_rows > 0): ?>
            <ul>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li> Name: <?php echo htmlspecialchars($row['name']); ?></li>
    <?php endwhile; ?>        
                </ul>
        <?php else: ?>
            <p>Keine Ergebnisse gefunden.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
