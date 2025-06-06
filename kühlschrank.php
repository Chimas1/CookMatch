<?php
require_once("Database.php");


$mysqli = new mysqli("localhost", $username, $password, $database);

// Don't forget to properly escape your values before you send them to DB
// to prevent SQL injection attacks.

$field1 = $mysqli->real_escape_string($_POST['field1']);


$query = "INSERT INTO table_name (col1, col2, col3, col4, col5)
            VALUES ('{$field1}','{$field2}','{$field3}','{$field4}','{$field5}')";

$mysqli->query($query);
$mysqli->close();



$query = "SELECT * FROM table_name";
echo "<b> <center>Database Output</center> </b> <br> <br>";

if ($result = $mysqli->query($query)) {

    while ($row = $result->fetch_assoc()) {
        $field1name = $row["col1"];
       

        echo '<b>'.$field1name.$field2name.'</b><br />';
        echo $field5name.'<br />';
        echo $field5name.'<br />';
        echo $field5name;
    }

/*freeresultset*/
$result->free();
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
