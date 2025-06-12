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
    $this->conn->query($query_string);
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
    echo $query_string;
    echo $binder;
    echo $value;
    $stmt = $this->preparedStm($query_string, $binder, $value);
    /* execute query */
    $stmt->execute();
    /* bind result variables */
    $stmt->bind_result($res);

    /* fetch value */
    $stmt->fetch();
    return $res;
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
    $conn->close();
  }
}
?>
