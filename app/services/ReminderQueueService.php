<?php
require_once __DIR__ . '/../repositories/ReminderQueueRepository.php';
require_once __DIR__ . '/../services/MailService.php';

class ReminderQueueService {

    private ReminderQueueRepository $repo;
    private MailService $mailer;

    public function __construct() {
        $this->repo = new ReminderQueueRepository();
        $this->mailer = new MailService();
    }


    public function scheduleReminder(int $event_id, int $user_id, string $scheduled_at): bool {
        $this->repo->deleteByEvent($event_id);
        return $this->repo->insert($event_id, $user_id, $scheduled_at);
    }

    public function deleteFromQueue(int $event_id) : bool {
        return $this->repo->deleteByEvent($event_id);
    }

    public function getEventFromQueue(int $event_id) : bool {
        return $this->repo->findByEventId($event_id);
    }



    public function processPendingReminders(): int {
        $reminders = $this->repo->getPendingReminders();
        if (!$reminders) return 0;

        $sentCount = 0;

        foreach ($reminders as $row) {
            $subject = "Erinnerung: " . $row['title'];
            $message = $this->mailer->buildReminderEmail(
                $row['user_name'],
                $row['title'],
                $row['event_date']
            );

            try {
                $ok = $this->mailer->sendMail($row['user_email'], $subject, $message);
                if ($ok) {
                    $this->repo->markAsSent($row['q_id'], $row['event_id']);
                    $sentCount++;
                    $this->log("Sent to {$row['user_email']} ({$row['title']})");
                } else {
                    $this->repo->markAsFailed($row['q_id'], 'sendMail returned false');
                    $this->log("Send failed (false) for {$row['user_email']}");
                }
            } catch (Throwable $e) {
                $this->repo->markAsFailed($row['q_id'], $e->getMessage());
                $this->log("Error sending to {$row['user_email']}: " . $e->getMessage());
            }
        }

        $this->log("Emails sent: {$sentCount}");
        return $sentCount;
    }

    private function log(string $msg): void {
        file_put_contents(__DIR__ . '/../cron/cron.log',
            "[" . date('Y-m-d H:i:s') . "] {$msg}\n",
            FILE_APPEND
        );
    }
}
