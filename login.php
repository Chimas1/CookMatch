<?php 
session_start();
require_once 'Database.php';

if(isset($_GET['login'])) {
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];

      $db = new Database();
      $db->connect();
 
    $userpasswort = $db->select("SELECT Passwort FROM Nutzer WHERE email = ?", "s", $email);
    $username = $db->select("SELECT Benutzername FROM Nutzer WHERE email = ?", "s", $email);

        
    //Überprüfung des Passworts
    if ($username !== null && password_verify($passwort, $userpasswort)) {
        $_SESSION['userid'] = $username['Benutzername'];
        die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }
    
}
?>
<!DOCTYPE html> 
<html> 
<head>
  <title>Login</title>    
</head> 
<body>
 
<?php 
if(isset($errorMessage)) {
    echo $errorMessage;
}
?>
 
<form action="?login=1" method="post">
E-Mail:<br>
<input type="email" size="40" maxlength="250" name="email"><br><br>
 
Dein Passwort:<br>
<input type="password" size="40"  maxlength="250" name="passwort"><br>
 
<input type="submit" value="Abschicken">
</form> 
</body>
</html>
