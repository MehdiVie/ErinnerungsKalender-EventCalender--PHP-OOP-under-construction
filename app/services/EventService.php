<?php
require_once __DIR__ . '/../repositories/EventRepository.php';
require_once __DIR__ . '/MailService.php';
require_once __DIR__ . '/ValidationService.php';
require_once __DIR__ . '/ReminderQueueService.php';

class EventService {
    private EventRepository $repo;
    private MailService $mailer;
    private ValidationService $validation;
    private ReminderQueueService $queueService;
    
    public function __construct() {
        $this->repo = new EventRepository();
        $this->mailer = new MailService();
        $this->validation = new ValidationService();
        $this->queueService = new ReminderQueueService();
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
                        //'description' => $data['description'] , 
                        'event_date' => $data['event_date'] ,
                        'reminder_time' => $data['reminder_time']
                    ]);

        $updated = false;
        if ($new_event) {
        
            /*if (!empty($data['reminder_time'])) {
                
                $queueService->scheduleReminder(
                    $this->repo->getLastInsertId(), 
                    $_SESSION['user_id'],
                    $data['reminder_time']
                );
            }*/

            //$this->checkSendEmail($data['title'], $data['event_date'], $updated);
            $_SESSION['flash_message_create'] = 'Bezeichnung Erfolgreich erstellt.';
            return ['success' => true];
        }

        return [
            'success' => false,
            'errors' => ['Fehler beim Erstellen der Bezeichnung. Versuchen Sie noch einmal.'],
            'event' => $data
        ];

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
                        //'description' => $data['description'] , 
                        'event_date' => $data['event_date'] ,
                        'reminder_time' => $data['reminder_time']
                    ]);

            
        $updated = true;

        if ($updated_event) {

            if ($this->queueService->getEventFromQueue($event_id)) {
                $this->queueService->deleteFromQueue($event_id);
            }
            /*
            if (!empty($data['reminder_time'])) {
                
                $queueService->scheduleReminder(
                    $event_id,
                    $_SESSION['user_id'],
                    $data['reminder_time']
                );
            } else {
                
                if ($queueService->getEventFromQueue($event_id)) {
                    $queueService->deleteFromQueue($event_id);
                }
                    
            }
            */

            //$this->checkSendEmail($data['title'], $data['event_date'], $updated);
            return ['success' => true];
        }

        return [
            'success' => false,
            'errors' => ['Fehler beim Bearbeiten der Bezeichnung. Versuchen Sie noch einmal.'],
            'event' => $data
        ];
    }

    public function deleteEvent(int $event_id , int $user_id) : bool {
        
        $deleted_event = $this->repo->delete($event_id,$user_id);
        /*
        if ($deleted_event) {
            $_SESSION['flash_message_delete']="Bezeichnung Erfolgreich gelöcht.";
        } else {
            $_SESSION['flash_message_delete']="Fehler beim Löchen. Versuchen Sie noch einmal!";
        }*/
        return $deleted_event;
    }

    public function checkSendEmail(string $event_title , 
                                    string $event_date, bool $updated) : void {
        if ($updated) {
            $event_title = "(Updated Termin)" . $event_title ;
        }

        $sentEmail = $this->mailer->preSendEmail($event_title , $event_date);

        if ($sentEmail) {
            $_SESSION['flash_message_email'] = 'E-Mail wurde erfolgreich gesendet!';
        }

    }


}