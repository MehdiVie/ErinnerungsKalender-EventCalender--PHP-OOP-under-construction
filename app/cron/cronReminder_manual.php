<?php

require_once __DIR__ . '/cronReminder.php';
$_SESSION['flash_message_email'] = 'E-Mail-Reminder wurde manuell ausgeführt.';
header("Location: " . BASE_URL . "/");
exit;
