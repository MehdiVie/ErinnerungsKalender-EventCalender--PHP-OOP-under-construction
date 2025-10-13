<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../libs/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../libs/PHPMailer/SMTP.php';
require_once __DIR__ . '/../libs/PHPMailer/Exception.php';


class MailService {

    private string $host;
    private int $port;
    private string $username;
    private string $password;
    private string $fromEmail;
    private string $fromName;
    private string $encryption;

    public function __construct() {
        $this->host       = $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com';
        $this->port       = (int) ($_ENV['MAIL_PORT'] ?? 587);
        $this->username   = $_ENV['MAIL_USERNAME'] ?? '';
        $this->password   = $_ENV['MAIL_PASSWORD'] ?? '';
        $this->fromEmail  = $_ENV['MAIL_FROM_EMAIL'] ?? $this->username;
        $this->fromName   = $_ENV['MAIL_FROM_NAME'] ?? 'Erinnerungskalender';
        $this->encryption = $_ENV['MAIL_ENCRYPTION'] ?? PHPMailer::ENCRYPTION_STARTTLS;
    }

    public function sendMail(string $to, string $subject, string $htmlMessage): bool {
        $mail = new PHPMailer(true);

        try {
            // SMTP-Konfiguration
            $mail->isSMTP();
            $mail->Host       = $this->host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->username;
            $mail->Password   = $this->password;   
            $mail->SMTPSecure = $this->encryption;
            $mail->Port       = $this->port;

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
            <p>Ihr Erinnerungskalender-Team</p>
        ";
    }

    public function preSendEmail(string $event_title , 
                                                string $event_date ) : bool {
        $message = $this->buildReminderEmail($_SESSION["user_name"] , $event_title , $event_date);
        $subject = "Erinnerung für " . $event_title;
        $to = $_SESSION["user_email"];
        return $this->sendMail($to,$subject,$message);

    }
}
