<?php

require_once 'Database.php';
session_start();

// Prüfen, ob der Nutzer eingeloggt ist
if (!isset($_SESSION['userid'])) {
    echo "Bitte zuerst einloggen.";
    echo '<a href="login.php">Bitte einloggen</a>';

}

$db = new Database();
$db->connect();

$userid = $_SESSION['userid'];
$result = $db->select("SELECT Profilbild, Benutzername, `E-Mail` FROM Nutzer WHERE Benutzername = ?", "s" ,  $userid);
$row = $result->fetch_assoc();

$db->disconnect();

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Nutzerprofil</title>
    <style>
        .profil-container {
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }
        .profilbild {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
        .profil-name {
            font-size: 1.5em;
            margin: 10px 0;
        }
        .profil-email {
            color: #555;
        }
    </style>
</head>
<body
     style="background-color:#FFA500;">
    <div class="profil-container">
        <?php if (!empty($row['Profilbild'])): ?>
        <img src="<?php echo htmlspecialchars($row['Profilbild']); ?>" alt="Profilbild" class="profilbild">
        <?php endif; ?>        <div class="profil-name"><?php echo htmlspecialchars($row['Benutzername']); ?></div>
        <div class="profil-email"><?php echo htmlspecialchars($row['E-Mail']); ?></div>
    </div>
    <a href="index.php">Zurück zur Startseite
</body>
</html>
