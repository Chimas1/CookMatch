<?php
require_once("Database.php");



      $db = new Database();
      $db->connect();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

//Hier die versprochene Überprüfung, ob der Nutzer eingeloggt ist, einfach // wegmachen, dann sollte es klappen
//session_start();
//if (!isset($_SESSION['userid'])) {
  //  die("Bitte zuerst einloggen. <br> <a href='login.php>Zum Login'</a>");
//}


// Don't forget to properly escape your values before you send them to DB
// to prevent SQL injection attacks.

$bezeichnung = $_POST['Bezeichnung'];
$benutzername = "";
$anzahl = $_POST['Anzahl'];


$query = "INSERT INTO `Besitzt` (`Bezeichnung`, `Benutzername`, `Anzahl`) VALUES (?, ?, ?)";
$result = $db->insert($query, "sss", [$bezeichnung, $benutzername, $anzahl]);

}

$query = "SELECT * FROM Besitzt";
$result = $db->query($query);
echo "<b> <center>Database Output</center> </b> <br> <br>";



if ($result) {

    while ($row = $result->fetch_assoc()) {

        echo '<b>'.$row["Bezeichnung"]." ".$row["Anzahl"].'</b><br />';
    }

$db->disconnect();
/*freeresultset*/
}

?>



<html>
  <head>
    
  </head>
  <body>
    
    <h1>Kühlschrank</h1>
    
  <form action="insert.php" method="post">
    Value 1: <input type="text" name = "Lebensmittel" /><br/>
 <input type="submit" />
</form>
    
  </body>
</html>
