<?php
require_once __DIR__ . '/../core/Model.php';

class ReminderQueueRepository extends Model {

    public function insert(int $event_id, int $user_id, string $scheduled_at): bool {
        $sql = "INSERT INTO reminder_queue (event_id, user_id, scheduled_at)
                VALUES (:event_id, :user_id, :scheduled_at)";
        $res = $this->query($sql, [
            ':event_id' => $event_id,
            ':user_id' => $user_id,
            ':scheduled_at' => $scheduled_at
        ]);
        return $res->rowCount() > 0;
    }

    public function deleteByEvent(int $event_id): bool {
        $sql = "DELETE FROM reminder_queue WHERE event_id = :event_id";
        $res = $this->query($sql, [':event_id' => $event_id]);
        return $res->rowCount() > 0;
    }

    public function getPendingReminders(): ?array {
        $sql = "
            SELECT 
                q.id AS q_id,
                q.user_id,
                q.scheduled_at,
                e.title,
                e.id AS event_id,
                e.event_date,
                e.reminder_time,
                u.name AS user_name,
                u.email AS user_email
            FROM reminder_queue q
            JOIN events e ON e.id = q.event_id
            JOIN users u ON u.id = e.user_id
            WHERE e.notified = 0
              AND q.status = 'pending'
              AND q.scheduled_at <= NOW()
              AND e.reminder_time IS NOT NULL
            ORDER BY q.scheduled_at ASC
            LIMIT 50
        ";
        $res = $this->query($sql);
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);
        return $rows ?: null;
    }

    public function markAsSent(int $queue_id, int $event_id): void {
        $this->query("
            UPDATE reminder_queue
            SET status='sent', attempts=attempts+1, sent_at=NOW(), last_error=NULL
            WHERE id = :id
        ", [':id' => $queue_id]);

        $this->query("
            UPDATE events
            SET notified = 1, notified_at = NOW()
            WHERE id = :event_id
        ", [':event_id' => $event_id]);
    }

    public function markAsFailed(int $queue_id, string $errorMessage): void {
        $this->query("
            UPDATE reminder_queue
            SET status='failed', attempts=attempts+1, last_error=:error
            WHERE id = :id
        ", [
            ':error' => substr($errorMessage, 0, 1000),
            ':id' => $queue_id
        ]);
    }
}
