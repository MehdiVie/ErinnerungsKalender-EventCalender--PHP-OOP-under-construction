<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../libs/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../libs/PHPMailer/SMTP.php';
require_once __DIR__ . '/../libs/PHPMailer/Exception.php';


class MailService {

    private string $fromEmail = "salimimehdibeti@gmail.com";
    private string $fromName  = "Erinnerungskalender";
    private string $appPassword = "kgphrlhqdfaditis"; // App Password Gmail

    public function sendMail(string $to, string $subject, string $htmlMessage): bool {
        $mail = new PHPMailer(true);

        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $this->fromEmail;
            $mail->Password = $this->appPassword;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Absender / Empfänger
            $mail->setFrom($this->fromEmail, $this->fromName);
            $mail->addAddress($to);

            // Inhalt
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $htmlMessage;

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }

    public function buildReminderEmail(string $userName, string $eventTitle, string $eventDate): string {
        return "
            <h3>Hallo {$userName},</h3>
            <p>Dies ist eine Erinnerung an Ihren Termin:</p>
            <p><strong>{$eventTitle}</strong> am <strong>{$eventDate}</strong></p>
            <br>
            <p>Viele Grüße,<br>Ihr Erinnerungskalender-Team</p>
        ";
    }

    public function preSendEmail(string $event_title , 
                                                string $event_date ) : bool {
        $message = buildReminderEmail($_SESSION["user_name"] , $event_title ,
                                        $event_date);
        $subject = "Erinnerung für " . $event_title;
        $to = $_SESSION["user_email"];
        return sendMail($to,$subject,$message);

    }
}
