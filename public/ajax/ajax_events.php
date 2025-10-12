<?php
error_reporting(0); 
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
        $data = [
            'title' => trim($_POST['title']),
            'description' => trim($_POST['description']),
            'event_date' => $_POST['event_date'],
            'reminder_time' => $_POST['reminder_time'] ?? null,
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
        $event = $service->getEvent($id);
        echo json_encode($event);
        break;

    default:
        echo json_encode(['error' => 'Invalid action']);
}
