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

//Ausgabe von Rezepten

$sql = "SELECT * FROM  Rezept"; 

$result = $conn->query($sql); 
  
if ($result->num_rows > 0) { 

    // ausgabe der daten pro zeile
  
    while($row = $result->fetch_assoc()) { 

        echo "id: ".$row["id"]." - Name : ".$row["Name"]."<br>"; 
        echo "id: ".$row["id"]." - Herkunft : ".$row["Herkunft"]."<br>"; 
        echo "id: ".$row["id"]." - Gang: ".$row["Gang"]."<br>"; 
        echo "id: ".$row["id"]." - Schwierigkeit: ".$row[" Schwierigkeit"]."<br>"; 
        echo "id: ".$row["id"]." - Ernährungsweise: ".$row["Ernährungsweise"]."<br>";
    } 

} else { 

    echo "0 results"; 

} 

//Ausgabe der passenden Zutaten

//Ausgabe der passenden Kochutensilien 

// Ausgabe passender Zeit 

// Ausgabe passender Anweisungen 

// Ausgabe passender Bewertungen 



// Conection schließen

$conn->close();
?>
