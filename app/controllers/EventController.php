<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../repositories/EventRepository.php';

class EventController extends Controller {
    private EventRepository $repo;

    public function __construct() {
        $this->repo = new EventRepository();
    }

    public function index() {
        $this->requireLogin();
        $events = $this->repo->getAllByUser($_SESSION["user_id"]);
        $this->view("events/list",['events'=> $events]);
    }

    public function create() {
        $this->requireLogin();
        $this->view("events/create");
    }

    public function store() {
        $this->requireLogin();
        if ($this->isPost()) {

            $this->repo->create([
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
        $event = $this->repo->findById($event_id);
        $this->view('events/edit', ['event' => $event]);
    }

    public function update() {
        $this->requireLogin();
        if ($this->isPost()) {
            $this->repo->update((int)$_POST['event_id'] , [
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
        $event = $this->repo->delete((int)$event_id, (int)$_SESSION['user_id']);
        $this->redirect("/");
    }
}
