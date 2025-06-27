<h2>Rezept erstellen</h2>
<form method="POST" >
    <label>Name des Rezepts:<br>
        <input type="text" name="Name" required>
    </label><br><br>

    <label>Beschreibung:<br>
        <textarea name="Beschreibung" required></textarea>
    </label><br><br>

    <label>Zutaten (je Zeile eine Zutat):<br>
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
print_r($__POST);
// Formularverarbeitung nach dem Absenden
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name          = isset($_POST["Name"]) ? htmlspecialchars($_POST["Name"]) : '';
    $Beschreibung  = isset($_POST["Beschreibung"]) ? htmlspecialchars($_POST["Beschreibung"]) : '';
    $Lebensmittel  = isset($_POST["Lebensmittel"]) ? htmlspecialchars($_POST["Lebensmittel"]) : '';
    $Gang          = isset($_POST["Gang"]) ? htmlspecialchars($_POST["Gang"]) : '';
    $Schwierigkeit = isset($_POST["Schwierigkeit"]) ? htmlspecialchars($_POST["Schwierigkeit"]) : '';
    $Ernaehrung    = isset($_POST["Ernaehrungsweise"]) ? htmlspecialchars($_POST["Ernaehrungsweise"]) : '';
    $Herkunft      = isset($_POST["Herkunft"]) ? htmlspecialchars($_POST["Herkunft"]) : '';
    $Zeit          = isset($_POST["Zeit"]) ? htmlspecialchars($_POST["Zeit"]) : '';

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




