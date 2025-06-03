<?php
class Database {
$servername; 
$username; 
$password; 
$dbname; 

$conn;

function __construct()
  {
    $this->servername = "localhost"; 
  $this->username = "CookMatch"; 
  $this->password = "SBScookmatch"; 
  $this->dbname = "CookMatch"; 
  }

function connect()
  {
    // Conection herstellen
    $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname); 
    

    if ($conn->connect_error) { 
        die("Connection failed: " . $conn->connect_error); 
    }

    //return $this->conn;
  }

function query($query_string)
  {
    $this->conn->query($query_string);
  }

  function preparedStm($query_string, $binder, $value)
  {
        $stmt = $this->conn->prepare($query_string);
        $stmt->bind_param($binder, $value);
        $stmt->execute();
        return $stmt->get_result();
  }

function disconnect()
  {
    // Conection schließen
    $conn->close();
  }
}
?>
