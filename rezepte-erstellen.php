<?php
// Formularverarbeitung nach dem Absenden
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $beschreibung = htmlspecialchars($_POST["beschreibung"]);
    $zutaten = htmlspecialchars($_POST["lebensmittel"]);
    $gang = htmlspecialchars($_POST["gang"]);
    $schwierigkeit = htmlspecialchars($_POST["schwierigkeit"]);
    $ernaehrung = htmlspecialchars($_POST["ernaehrungsweise"]);
    $herkunft = htmlspecialchars($_POST["herkunft"]);
    $zeit = htmlspecialchars($_POST["zeit"]);

    echo "<h2>Rezept erstellt!</h2>";
    echo "<strong>Name:</strong> $name<br>";
    echo "<strong>Beschreibung:</strong> $beschreibung<br>";
    echo "<strong>Zutaten:</strong> <pre>$zutaten</pre>";
    echo "<strong>Gang:</strong> $gang<br>";
    echo "<strong>Schwierigkeit:</strong> $schwierigkeit<br>";
    echo "<strong>Ernährungsweise:</strong> $ernaehrung<br>";
    echo "<strong>Herkunft:</strong> $herkunft<br>";
    echo "<strong>Zeit:</strong> $zeit Minuten<br>";
    echo "<hr>";
}
?>

<h2>Rezept erstellen</h2>
<form method="POST">
    <label>Name des Rezepts:<br>
        <input type="text" name="name" required>
    </label><br><br>

    <label>Beschreibung:<br>
        <textarea name="beschreibung" required></textarea>
    </label><br><br>

    <label>Zutaten (je Zeile eine Zutat):<br>
        <textarea name="zutaten" required></textarea>
    </label><br><br>

    <label>Gang:<br>
        <select name="gang" required>
            <option value="Vorspeise">Vorspeise</option>
            <option value="Hauptgericht">Hauptgericht</option>
            <option value="Dessert">Dessert</option>
        </select>
    </label><br><br>

    <label>Schwierigkeit:<br>
        <select name="schwierigkeit" required>
            <option value="Einfach">Einfach</option>
            <option value="Mittel">Mittel</option>
            <option value="Schwierig">Schwierig</option>
        </select>
    </label><br><br>

    <label>Ernährungsweise:<br>
        <select name="ernaehrung" required>
            <option value="Vegetarisch">Vegetarisch</option>
            <option value="Vegan">Vegan</option>
            <option value="Fleisch">Fleisch</option>
            <option value="Fisch">Fisch</option>
            <option value="Glutenfrei">Glutenfrei</option>
        </select>
    </label><br><br>

    <label>Herkunft:<br>
        <input type="text" name="herkunft" required>
    </label><br><br>

    <label>Zeit (in Minuten):<br>
        <input type="number" name="zeit" min="1" required>
    </label><br><br>

    <button type="submit">Rezept absenden</button>
</form>
