<?php
class Database {
private $servername; 
private $username; 
private $password; 
private $dbname; 

private $conn;

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
    

    if ( $this->conn->connect_error) { 
        die("Connection failed: " .  $this->conn->connect_error); 
    }

  }

function query($query_string)
  {
    return $this->conn->query($query_string);
  }

  function preparedStm($query_string, $binder, $value)
  {
        $stmt = $this->conn->prepare($query_string);
        if(is_array($value))
          $stmt->bind_param($binder, ...$value);
        else
          $stmt->bind_param($binder, $value);

    
        return $stmt;
  }

  //WICHTIG: Wenn ihr SELECT Anweisungen stellt immer nur EINEN Wert übergeben
  function select($query_string, $binder, $value)
  {
    if(strlen($binder) == 0) {
      $stmt = $this->query($query_string);
      return  mysqli_num_rows($stmt) > 0 ? $stmt->fetch_assoc() : "No Results";
    }
    $stmt = $this->preparedStm($query_string, $binder, $value);
    /* execute query */
    $stmt->execute();
    
    return $stmt->get_result();
  }

  function insert($query_string, $binder, $value)
  {
    $stmt = $this->preparedStm($query_string, $binder, $value);
    /* execute query */
    return $stmt->execute();
  }

function disconnect()
  {
    // Conection schließen
    $this->conn->close();
  }
}
?>
