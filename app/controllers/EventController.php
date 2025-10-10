<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../services/EventService.php';

class EventController extends Controller {
    
    private EventService $service;
    

    public function __construct() {
        $this->service = new EventService();
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

            $response=$this->service->createEvent([
                        'user_id' => $_SESSION['user_id'] ,
                        'title' => trim($_POST['title']) , 
                        'description' => trim($_POST['description']) , 
                        'event_date' => $_POST['event_date'] ,
                        'reminder_time' => !empty($_POST['reminder_time']) ? 
                                            $_POST['reminder_time'] : null
                    ]);



            if (!$response['success']) {
                $this->view('events/create' ,[
                    'errors' => $response['errors'] , 
                    'event' => $response['event']
                ]);
            } else  {
                $this->redirect('/', ['message'=> $response['message']]);
            } 
        }
        else {
            $this->redirect('/');
        } 
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
            $response=$this->service->updateEvent($_POST["event_id"] , [
                        'user_id' => $_SESSION['user_id'] ,
                        'id' => $_POST["event_id"] ,
                        'title' => trim($_POST['title']) , 
                        'description' => trim($_POST['description']) , 
                        'event_date' => $_POST['event_date'] ,
                        'reminder_time' => !empty($_POST['reminder_time']) ? 
                                            $_POST['reminder_time'] : null
                    ]);

            if (!$response['success']) {
                $this->view('events/edit' ,[
                    'errors' => $response['errors'] , 
                    'event' => $response['event']
                ]);
            } else  {
                $this->redirect('/', ['message'=> $response['message']]);
            } 
        }
        else {
            $this->redirect('/');
        }
        
        
    }

    public function delete() {
        $this->requireLogin();
        $event_id = $_GET['id'] ?? null;
        $event = $this->service->deleteEvent((int)$event_id, (int)$_SESSION['user_id']);
        $this->redirect("/");
    }

}
