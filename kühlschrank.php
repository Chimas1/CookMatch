<?php
require_once("Database.php");



      $db = new Database();
      $db->connect();
      //Hier die versprochene Überprüfung, ob der Nutzer eingeloggt ist, einfach // wegmachen, dann sollte es klappen
//session_start();
//if (!isset($_SESSION['userid'])) {
  //  die("Bitte zuerst einloggen. <br> <a href='login.php>Zum Login'</a>");
//}
$benutzername = "";
// Check if the form is submitted
if (!isset($_SESSION['userid'])) {
    echo "Bitte zuerst einloggen.";
    echo '<a href="rezepte-suchen.php">Zu den Rezepten</a>';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Don't forget to properly escape your values before you send them to DB
  // to prevent SQL injection attacks.

  $bezeichnung = $__POST['Bezeichnung'];
  $anzahl = $__POST['Anzahl']>0;


  $query = "INSERT INTO `Besitzt` (`Bezeichnung`, `Benutzername`, `Anzahl`) VALUES (?, ?, ?)";
  $result = $db->insert($query, "sss", [$bezeichnung, $benutzername, $anzahl]);
}

$query = "SELECT * FROM Besitzt WHERE Benutzername = ? ORDER BY Bezeichnung ASC";
$result = $db->select($query, "s", [$benutzername]);
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
    Lebensmittel: <input type="text" name = "Bezeichnung" /><br/>
    Anzahl: <input type="number" name = "Anzahl" /><br/>
 <input type="submit" />
</form>
    
  </body>
</html>
