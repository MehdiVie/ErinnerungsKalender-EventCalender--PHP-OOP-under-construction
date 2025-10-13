<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../services/ReminderQueueService.php';

class ReminderQueueController extends Controller {

    private ReminderQueueService $service;
    
    public function __construct() {
        $this->service = new ReminderQueueService();
    }

    public function index() {
        $this->requireLogin();
        $reminders = $this->service->getReminders();
        $this->view("reminders/index",['reminders'=> $reminders]);
    }

    public function runcron() {
        $this->requireLogin();
        $this->service->runManualCron();
        $this->redirect('/reminders');
    }

}