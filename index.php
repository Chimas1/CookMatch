
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
<body
     style="background-color:#FFA500;">
    <h1>Willkommen bei CookMatch!</h1>
    <p>
       <a href="rezepte-suchen.php"style="color:black;">Zu den Rezepten</a> <br/>
        <a href="Nutzer.php"style="color:black;">Zum Profil</a> <br/>
        <a href="rezepte-anzeigen.php?name=Pizza"style="color:black;">Pizza</a> <br/>
        <a href="Favoriten.php"style="color:black;">Zu deinen Favoriten</a> <br/>
    </p>
    <form action="logout.php" method="post" style="display: inline;">
        <button type="submit">Logout</button>
    </form>
</body>
</html>
