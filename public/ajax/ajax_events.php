<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/../../app/services/EventService.php';

$service = new EventService();

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'delete':
        $id = (int)$_POST['id'];
        $success = $service->deleteEvent($id, $_SESSION['user_id']);
        echo json_encode(['success' => $success]);
        break;

    case 'update':
        $id = (int)$_POST['id'];
        $rt = trim($_POST['reminder_time'] ?? '');
        $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'event_date' => $_POST['event_date'],
                'reminder_time' => $rt !== '' ? $rt : null,
                'user_id' => $_SESSION['user_id']
        ];

        $result = $service->updateEvent($id, $data);
        echo json_encode($result);
        break;


    case 'list':
        $events = $service->getUserEvents($_SESSION['user_id']);
        echo json_encode($events);
        break;

    case 'get':
        $id = (int)$_POST['id'];
        $ev = $service->getEvent($id);

        if ($ev) {
            
            if (!empty($ev['reminder_time'])) {
                $ev['reminder_time_input'] = date('Y-m-d\TH:i', strtotime($ev['reminder_time']));
            } else {
                $ev['reminder_time_input'] = '';
            }
            echo json_encode($ev);
        } else {
            echo json_encode(['error' => 'Event nicht gefunden']);
        }
        break;


    default:
        echo json_encode(['error' => 'Invalid action']);
}
