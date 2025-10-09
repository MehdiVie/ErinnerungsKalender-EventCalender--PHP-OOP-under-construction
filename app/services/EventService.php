<?php
require_once __DIR__ . '/../repositories/EventRepositories.php';
require_once __DIR__ . '/MailService.php';

class EventService {
    private EventRepository $repo;
    private MailService $mailer;

    public function __construct() {
        $this->repo = new EventRepository();
        $this->mailer = new MailService();
    }

    public function getUserEvents(int $user_id) : ?array {
        $events = $this->repo->getAllByUser($user_id);
        return $events;
    }

    public function createEvent(array $data) :  bool {

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
        }

        return $new_event;

    }

    public function getEvent(int $event_id) : ?array {
        $event = $this->repo->findById($event_id);
        return $event;
    }

    public function updateEvent(int $event_id , array $data) : bool {

        $updated_event= $this->repo->update($event_id , [
                        'user_id' => $_SESSION['user_id'] ,
                        'title' => $data['title'] , 
                        'description' => $data['description'] , 
                        'event_date' => $data['event_date'] ,
                        'reminder_time' => !empty($data['reminder_time']) ? 
                                            $data['reminder_time'] : null
                    ]);
            
        if ($updated_event) {
            $this->checkSendEmail($data['title'],$data['event_date']);
        }

        return $updated_event;
    }

    public function deleteEvent(int $event_id , int $user_id) : bool {
        $deleted_event = $this->repo->delete($event_id,$user_id);
        return $deleted_event;
    }

    public function checkSendEmail(string $event_title , 
                                    string $event_date) : void {

        $sentEmail = $this->mailer->preSendEmail($event_title , $event_date);

        if ($sentEmail) {
            $_SESSION['flash_message'] = 'E-Mail wurde erfolgreich gesendet!';
        }

    }


}