<?php
require_once __DIR__ . '/../app/services/MailService.php';

$mail = new MailService();

$html = $mail->buildReminderEmail("Mehdi", "Nila Geburtstag", "12.10.2025");

if ($mail->sendMail("salimimehdibeti@gmail.com", "Test mit PHPMailer", $html)) {
    echo "Email erfolgreich gesendet!";
} else {
    echo "Fehler beim Senden! (Check error_log)";
}
