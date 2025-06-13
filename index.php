<?php
 echo "test";

<?php
session_start();
// Optional: Login-Prüfung
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Startseite</title>
</head>
<body>
    <h1>Willkommen bei CookMatch!</h1>
    <p>
        <a href="rezepte-suchen.php">Zu den Rezepten</a>
    </p>
    <form action="logout.php" method="post" style="display: inline;">
        <button type="submit">Logout</button>
    </form>
</body>
</html>
 echo "<a href='interaktionen-mit-rezepten/anzeige-von-rezepte.php'>Rezepte anzeigen</a>";
?>
