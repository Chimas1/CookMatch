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
<body>
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
