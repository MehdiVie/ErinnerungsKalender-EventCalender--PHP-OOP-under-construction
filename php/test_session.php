<?php
require_once __DIR__ . '/session.php';

$_SESSION['check'] = 'Session funktioniert!';

echo "<p>Session gestartet!</p>";
echo "<a href='test_session_2.php'>Weiter</a>";
