<?php
require_once __DIR__ . '/../app/services/MailService.php';

$mail = new MailService();

$to = "salimimehdibeti@gmail.com";
$subject = "Erinnerungskalender!";
$message = $mail->buildReminderEmail("Mehdi","Nila Geburtstag","12-10-2025");

if ($mail->sendEmail($to , $subject , $message)) {
    echo "Email sent.";
} else {
    echo "Email nicht sent";
}