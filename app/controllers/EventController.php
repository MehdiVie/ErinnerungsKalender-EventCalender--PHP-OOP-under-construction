<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../repositories/EventRepository.php';
require_once __DIR__ . '/../services/MailService.php';

class EventController extends Controller {
    //private EventRepository $repo;
    private EventService $service;
    

    public function __construct() {
        //$this->repo = new EventRepository();
        $this->service = new EventService();
        //$this->mailer = new MailService();
    }

    public function index() {
        $this->requireLogin();
        $events = $this->service->getUserEvents($_SESSION["user_id"]);
        $this->view("events/list",['events'=> $events]);
    }

    public function create() {
        $this->requireLogin();
        $this->view("events/create");
    }

    public function store() {
        $this->requireLogin();
        if ($this->isPost()) {

            $this->service->createEvent([
                        'user_id' => $_SESSION['user_id'] ,
                        'title' => $_POST['title'] , 
                        'description' => $_POST['description'] , 
                        'event_date' => $_POST['event_date'] ,
                        'reminder_time' => !empty($_POST['reminder_time']) ? 
                                            $_POST['reminder_time'] : null
                    ]);
        }
        
        $this->redirect('/');   
    }

    public function edit() {
        $this->requireLogin();
        $event_id = (int)($_GET['id'] ?? 0);
        $event = $this->service->getEvent($event_id);
        $this->view('events/edit', ['event' => $event]);
    }

    public function update() {
        $this->requireLogin();
        if ($this->isPost()) {
            $this->service->updateEvent($_POST["event_id"] , [
                        'user_id' => $_SESSION['user_id'] ,
                        'title' => $_POST['title'] , 
                        'description' => $_POST['description'] , 
                        'event_date' => $_POST['event_date'] ,
                        'reminder_time' => !empty($_POST['reminder_time']) ? 
                                            $_POST['reminder_time'] : null
                    ]);
        }
        
        $this->redirect('/');
        
    }

    public function delete() {
        $this->requireLogin();
        $event_id = $_GET['id'] ?? null;
        $event = $this->service->deleteEvent((int)$event_id, (int)$_SESSION['user_id']);
        $this->redirect("/");
    }

}
