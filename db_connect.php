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

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
 
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo "Datenbankverbindung fehlgeschlagen: " . $e->getMessage();
    exit;
}

echo "Verbindung hergestellt";

// Conection schließen

$conn->close();
?>
