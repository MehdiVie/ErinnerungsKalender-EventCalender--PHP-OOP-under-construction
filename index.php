<?php
require_once __DIR__ . "/php/session.php";

if (!isset($_SESSION["user_id"])) {
    header('Location php/login.php');
    exit;
}

echo "<h3>Wilkommen, ". htmlspecialchars($_SESSION["user_name"]) . "!</h2>";
echo "<p>Du bist eingeloggt!</p>";
echo "<a href='php/logout.php'>Logout</a>";

?>