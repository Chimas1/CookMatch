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


if (isset($_POST['update'])) {
    $neuerBenutzername = trim($_POST['benutzername']);

    // Prüfen, ob der neue Benutzername 
        $result = $db->select("SELECT Benutzername FROM Nutzer WHERE `Benutzername` = ?", "s", $neuerBenutzername);
        if($result->num_rows > 0) {
            echo "Benutzername existiert bereits!";
            $neuerBenutzername = $userid;
    } 
        $profilbildPfad = $row['Profilbild']; // Standard: altes Bild behalten
        if (isset($_FILES['profilbild']) && $_FILES['profilbild']['error'] == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['profilbild']['tmp_name'];
            $name = basename($_FILES['profilbild']['name']);
            $upload_dir = "uploads/"; // Stelle sicher, dass der Ordner existiert und beschreibbar ist
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $profilbildPfad = $upload_dir . uniqid() . "_" . $name;
            move_uploaded_file($tmp_name, $profilbildPfad);
         }

        // Update in der Datenbank
        $updateStmt = $db->insert(
            "UPDATE Nutzer SET Benutzername = ?, Profilbild = ? WHERE Benutzername = ?",
            "sss",
            [$neuerBenutzername, $profilbildPfad, $userid]
        );

        // Username in der Session aktualisieren
        $_SESSION['userid'] = $neuerBenutzername;
        // Seite neu laden, damit Änderungen sichtbar sind
        header("Location: Nutzer.php");
        exit;
   
    }
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
       <form method="post" enctype="multipart/form-data">
        <label for="benutzername">Benutzername:</label>
        <input type="text" name="benutzername" id="benutzername" value="<?php echo htmlspecialchars($row['Benutzername']); ?>" required><br>
        <label for="profilbild">Profilbild ändern:</label>
        <input type="file" name="profilbild" id="profilbild" accept="image/*"><br>
        <button type="submit" name="update">Änderungen speichern</button>
    </form>
    <a href="index.php">Zurück zur Startseite
</body>
</html>
