<?php
require_once("Database.php");


      $db = new Database();
      $db->connect();

// Don't forget to properly escape your values before you send them to DB
// to prevent SQL injection attacks.

$zutat = $_POST['zutat'];
$benutzername = "";
$anzahl = $_POST['anzahl'];


$query = "INSERT INTO `Besitzt` (`Bezeichnung`, `Benutzername`, `Anzahl`) VALUES (?, ?, ?)";
$result = $db->insert($query, "sss", [$zutat, $benutzername, $anzahl]);



$query = "SELECT * FROM Besitzt";
$result = $db->query($query);
echo "<b> <center>Database Output</center> </b> <br> <br>";



if ($result) {

    while ($row = $result->fetch_assoc()) {
        $field1name = $row["Bezeichnung"];
       
        $field2name = $row["Anzahl"];

        echo '<b>'.$field1name.$field2name.'</b><br />';
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
