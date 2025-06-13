<?php
session_start();
session_unset();    // Alle Session-Variablen entfernen
session_destroy();  // Die Session selbst zerstören
header("Location: login.php"); // Weiterleitung zur Login-Seite
exit();
?>
