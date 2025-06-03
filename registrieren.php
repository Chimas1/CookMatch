<?php 
session_start();
require_once 'Database.php';
?>
<!DOCTYPE html> 
<html> 
<head>
  <title>Registrierung</title>    
</head> 
<body>
 
<?php
$showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll
 
if(isset($_GET['register'])) {
  
    $benutzername = $_POST['benutzername'];
    $error = false;
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];

  
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }     
    if(strlen($passwort) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
    if($passwort != $passwort2) {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }
    
        // Überprüfen, ob E-Mail schon existiert
    if(!$error) {
      $db = new Database();
      $db->connect();
      $result = $db->preparedStm("SELECT * FROM Nutzer WHERE `E-Mail` = ?", "s", $email);
        $user = $result->fetch_assoc();
 
        if($user !== null) {
            die ("Diese E-Mail-Adresse ist bereits vergeben<br>");
            $error = true;
        }

      $user = null;
      
      $result = $db->preparedStm("SELECT * FROM Nutzer WHERE `Benutzername` = ?", "s", $benutzername);
        $user = $result->fetch_assoc();
 
        if($user !== null) {
            die ("Dieser Benutzername ist bereits vergeben<br>");
            $error = true;
        }


      $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);
 
        $result = $db->preparedStm("INSERT INTO Nutzer (Benutzername, `E-Mail`, Passwort) VALUES (?, ?, ?)", "sss", [$benutzername, $email, $passwort_hash]);
 
        if($result) {
            echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
            $showFormular = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
 
        $stmt->close();

    }

}
 
if($showFormular) {
?>
 
<form action="?register=1" method="post">

Benutzername:<br>
<input type="benutzername" size="40" maxlength="250" name="benutzername"><br><br>  
  
E-Mail:<br>
<input type="email" size="40" maxlength="250" name="email"><br><br>
 
Dein Passwort:<br>
<input type="password" size="40"  maxlength="250" name="passwort"><br>
 
Passwort wiederholen:<br>
<input type="password" size="40" maxlength="250" name="passwort2"><br><br>  
 
<input type="submit" value="Abschicken">
</form>
 
<?php
} //Ende von if($showFormular)
?>
 
</body>
</html>
