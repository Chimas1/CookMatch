<?php

  $servername = "localhost"; 

$username = "CookMatch"; 

$password = "SBScookmatch"; 

$dbname = "CookMatch"; 

// Conection herstellen

$conn = new mysqli($servername, $username, $password, $dbname); 

// Conection prüfen 

if ($conn->connect_error) { 

    die("Connection failed: " . $conn->connect_error); 
}

echo "Verbindung hergestellt";

// Conection schließen

$conn->close();
?>
