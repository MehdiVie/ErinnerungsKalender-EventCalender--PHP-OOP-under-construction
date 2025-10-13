<?php

set_time_limit(0);
date_default_timezone_set('Europe/Vienna');

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../services/ReminderQueueService.php';

$db = Database::getInstance();

// prevent concurrent cron executions
try {
    $lock = $db->query("SELECT GET_LOCK('reminder_sender_lock', 2)");
    $hasLock = (int)$lock->fetchColumn() === 1;

    if (!$hasLock) {
        file_put_contents(__DIR__ . '/cron.log',
            "[" . date('Y-m-d H:i:s') . "] Ein anderer Cron-Prozess läuft bereits.\n",
            FILE_APPEND
        );
        exit(0);
    }

    //run reminder process
    $service = new ReminderQueueService();
    $sentCount = $service->processPendingReminders();

    $msg = "[" . date('Y-m-d H:i:s') . "] CRON wurde erfolgreich abgeschlossen – E-Mails wurden gesendet.: {$sentCount}\n";
    file_put_contents(__DIR__ . '/cron.log', $msg, FILE_APPEND);

    $_SESSION['flash_message_cron'] = 'Run-Cron (Email Skript) manuell wurde ausgeführt.';

    echo $msg;


} catch (Throwable $e) {
    //log unexpected errors
    $error = "[" . date('Y-m-d H:i:s') . "] Exception: " . $e->getMessage() . "\n";
    file_put_contents(__DIR__ . '/cron.log', $error, FILE_APPEND);
    echo $error;

} finally {
    //always release lock
    try {
        $db->query("SELECT RELEASE_LOCK('reminder_sender_lock')");
    } catch (Throwable $ignore) {}
}


