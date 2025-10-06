<?php
require_once __DIR__ . '/db_connect.php';

$db = Database::getInstance();

if ($db) {
    echo "✅ Verbindung erfolgreich!";
} else {
    echo "❌ Verbindung fehlgeschlagen!";
}
?>
