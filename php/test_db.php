<?php
require_once __DIR__ . '/db_connect.php';

try {
    $db = Database::getInstance();
    echo "<p> Datenbank-Verbindung erfolgreich!</p>";
} catch (PDOException $e) {
    echo "<p> Fehler: " . $e->getMessage() . "</p>";
}
