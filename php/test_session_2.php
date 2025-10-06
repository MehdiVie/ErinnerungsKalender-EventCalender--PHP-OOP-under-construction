<?php
require_once __DIR__ . '/session.php';

if (isset($_SESSION['check'])) {
    echo "<p>" . $_SESSION['check'] . "</p>";
} else {
    echo "<p>Session wurde nicht gefunden.</p>";
}
