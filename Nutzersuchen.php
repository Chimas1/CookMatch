
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
    <title>Benutzersuche</title>
</head>
<body>
    <form action="Nutzersuchen.php" method="get">
        <input type="text" name="suche" placeholder="Benutzer suchen">
        <button type="submit">Suchen</button>
    </form>
    <br>
    <a href="Nutzer.php">Zurück zum Profil</a>
</body>
</html>
