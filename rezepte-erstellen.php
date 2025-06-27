<?php
require_once 'Database.php';

    $db = new Database();
    $db->connect();

    $lebensmittel = $db->select("SELECT * FROM Lebensmittel","",[]);
?>
<h2>Rezept erstellen</h2>
<form method="POST" >
    <label>Name des Rezepts:<br>
        <input type="text" name="Name" required>
    </label><br><br>

    <label>Beschreibung:<br>
        <textarea name="Beschreibung" required></textarea>
    </label><br><br>

    <label>Zutaten (mehre mit STRG wählen):<br>
        <select name="Zutaten" multiple>
            <?php
                while ($row = $lebensmittel->fetch_assoc())
                    echo "<option value='$row'>'$row'</option>";
            ?>
            
        </select>
        <textarea name="Zutaten" required></textarea>
    </label><br><br>

    <label>Gang:<br>
        <select name="Gang" required>
            <option value="Vorspeise">Vorspeise</option>
            <option value="Hauptgericht">Hauptgericht</option>
            <option value="Dessert">Dessert</option>
        </select>
    </label><br><br>

    <label>Schwierigkeit:<br>
        <select name="Schwierigkeit" required>
            <option value="Einfach">Einfach</option>
            <option value="Mittel">Mittel</option>
            <option value="Schwierig">Schwierig</option>
        </select>
    </label><br><br>

    <label>Ernährungsweise:<br>
        <select name="Ernaehrung" required>
            <option value="Vegetarisch">Vegetarisch</option>
            <option value="Vegan">Vegan</option>
            <option value="Fleisch">Fleisch</option>
            <option value="Fisch">Fisch</option>
            <option value="Glutenfrei">Glutenfrei</option>
        </select>
    </label><br><br>

    <label>Herkunft:<br>
        <input type="text" name="Herkunft" required>
    </label><br><br>

    <label>Zeit (in Minuten):<br>
        <input type="number" name="Zeit" min="1" required>
    </label><br><br>

    <button type="submit">Rezept absenden</button>
</form>

<?php

print_r($_POST);
// Formularverarbeitung nach dem Absenden
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name          = isset($_POST["name"]) ? htmlspecialchars($_POST["name"]) : '';
    $Beschreibung  = isset($_POST["beschreibung"]) ? htmlspecialchars($_POST["beschreibung"]) : '';
    $Lebensmittel  = isset($_POST["lebensmittel"]) ? htmlspecialchars($_POST["lebensmittel"]) : '';
    $Gang          = isset($_POST["gang"]) ? htmlspecialchars($_POST["gang"]) : '';
    $Schwierigkeit = isset($_POST["schwierigkeit"]) ? htmlspecialchars($_POST["schwierigkeit"]) : '';
    $Ernaehrung    = isset($_POST["ernaehrung"]) ? htmlspecialchars($_POST["ernaehrung"]) : '';
    $Herkunft      = isset($_POST["herkunft"]) ? htmlspecialchars($_POST["herkunft"]) : '';
    $Zeit          = isset($_POST["zeit"]) ? htmlspecialchars($_POST["zeit"]) : '';


    //TODO Prüfe ob Rezept schon exisitert
    $db->select("SELECT Name from Rezept WHERE Name = ?", "s", [$Name]);

    $stmt = $db->insert("INSERT INTO Rezept(Name,Herkunft,Gang,Schwierigkeit,Ernährungsweise) VALUES (?,?,?,?,?)", "sssis", [$Name, $Herkunft, $Gang, $Schwierigkeit, $Ernaehrung]);


    echo "<h2>Rezept erstellt!</h2>";
    echo "<strong>Name:</strong> $Name<br>";
    echo "<strong>Beschreibung:</strong> $Beschreibung<br>";
    echo "<strong>Zutaten:</strong> <pre>$Lebensmittel</pre>";
    echo "<strong>Gang:</strong> $Gang<br>";
    echo "<strong>Schwierigkeit:</strong> $Schwierigkeit<br>";
    echo "<strong>Ernährungsweise:</strong> $Ernaehrung<br>";
    echo "<strong>Herkunft:</strong> $Herkunft<br>";
    echo "<strong>Zeit:</strong> $Zeit Minuten<br>";
    echo "<hr>";
}
?>




