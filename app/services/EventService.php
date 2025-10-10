<?php
require_once __DIR__ . '/../repositories/EventRepository.php';
require_once __DIR__ . '/MailService.php';
require_once __DIR__ . '/ValidationService.php';

class EventService {
    private EventRepository $repo;
    private MailService $mailer;
    private ValidationService $validation;

    public function __construct() {
        $this->repo = new EventRepository();
        $this->mailer = new MailService();
        $this->validation = new ValidationService();
    }

    public function getUserEvents(int $user_id) : ?array {
        $events = $this->repo->getAllByUser($user_id);
        return $events;
    }

    public function createEvent(array $data) :  array {

        $errors = $this->validation->validateEvent($data);

        if (!empty($errors)) {
            return ['success' => false , 'errors' => $errors , 
                    'event' => $data ];
        }

        $new_event = $this->repo->create([
                        'user_id' => $_SESSION['user_id'] ,
                        'title' => $data['title'] , 
                        'description' => $data['description'] , 
                        'event_date' => $data['event_date'] ,
                        'reminder_time' => !empty($data['reminder_time']) ? 
                                            $data['reminder_time'] : null
                    ]);
        
        if ($new_event) {
            $this->checkSendEmail($data['title'],$data['event_date']);
            $_SESSION['flash_message_create']= 'Termin Erfolgreich erstellt.';
            return ['success' => true ];
        } else {
            return ['success' => false , 
                    'errors' => ['Fehler beim Erstellen des Termins. Versuchen Sie noch  einmal.'] ,
                    'event' => $data
                   ];
        }

        

    }

    public function getEvent(int $event_id) : ?array {
        $event = $this->repo->findById($event_id);
        return $event;
    }

    public function updateEvent(int $event_id , array $data) : ?array {

        $errors = $this->validation->validateEvent($data);

        if (!empty($errors)) {
            return ['success'=> false , 'errors' => $errors , 'event' => $data];
        }

        $updated_event= $this->repo->update($event_id , [
                        'user_id' => $_SESSION['user_id'] ,
                        'title' => $data['title'] , 
                        'description' => $data['description'] , 
                        'event_date' => $data['event_date'] ,
                        'reminder_time' => !empty($data['reminder_time']) ? 
                                            $data['reminder_time'] : null
                    ]);
            
        if ($updated_event) {
            //$this->checkSendEmail($data['title'],$data['event_date']);
            $_SESSION['flash_message_update']= 'Termin Erfolgreich bearbeitet.';
            return ['success' => true ];
        } else {
            return ['success' => false , 
                    'errors' => ['Fehler beim Bearbeiten des Termins. Versuchen Sie noch  einmal.'] ,
                    'event' => $data
                   ];
        }
    }

    public function deleteEvent(int $event_id , int $user_id) : bool {
        $deleted_event = $this->repo->delete($event_id,$user_id);
        if ($deleted_event) {
            $_SESSION['flash_message_email']="Termin Erfolgreich gelöcht.";
        } else {
            $_SESSION['flash_message_email']="Fehler beim Löchen. Versuchen Sie noch einmal!";
        }
        return $deleted_event;
    }

    public function checkSendEmail(string $event_title , 
                                    string $event_date) : void {

        $sentEmail = $this->mailer->preSendEmail($event_title , $event_date);

        if ($sentEmail) {
            $_SESSION['flash_message_email'] = 'E-Mail wurde erfolgreich gesendet!';
        }

    }


}