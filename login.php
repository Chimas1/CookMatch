<?php 
session_start();
require_once 'Database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['login'])) {
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];

      $db = new Database();
      $db->connect();
 
    $userResult = $db->select("SELECT Benutzername, Passwort FROM Nutzer WHERE `E-Mail` = ?", "s", $email);
if ($userResult && $row = $userResult->fetch_assoc()) {
    $username = $row["Benutzername"];
    $userpasswort = $row["Passwort"];
    if (password_verify($passwort, $userpasswort)) {
        $_SESSION['userid'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }
} else {
    $errorMessage = "E-Mail oder Passwort war ungültig<br>";
}
    $db->disconnect();
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
