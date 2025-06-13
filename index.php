
<?php
session_start();

if (!isset($_SESSION['userid'])) {
    echo "Bitte zuerst einloggen.";
    echo '<a href="login.php">Bitte einloggen</a>';

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
        <a href="rezepte-suchen.php">Zu den Rezepten</a> <br/>
        <a href="Nutzer.php">Zum Profil</a> <br/>
        <a href="rezepte-anzeigen.php?name=pizza">Pizza</a> <br/>
    </p>
    <form action="logout.php" method="post" style="display: inline;">
        <button type="submit">Logout</button>
    </form>
</body>
</html>
