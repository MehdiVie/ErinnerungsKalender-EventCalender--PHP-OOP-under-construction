<?php

class ValidationService {

    public function validateRegistration(array $data) : ?array {

        $errors=[];
        
        if (empty(trim($data['name']))) {
            $errors[] = "Name darf nicht leer sein.";
        }

        if (empty(trim($data['email']))) {
            $errors[] = "Email darf nicht leer sein.";
        } else if (!filter_var($data['email'] , FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email muss gültig sein.";
        }

        if (empty($data['password'])) {
            $errors[] = "Password darf nicht leer sein.";
        } else if (strlen($data['password']) < 6) {
            $errors[] = "Password muss mindestens 6 Zeichen haben.";
        }

        return $errors;

    }

    public function validateEvent(array $data) : ?array {

        $errors = [];

        if (empty(trim($data['title']))) {
            $errors[] = "Termin Title darf nicht leer sein.";
        }

        if (empty(trim($data['event_date']))) {
            $errors[] = "Termin Datum darf nicht leer sein.";
        } else if (!$this->isValidEventDate($data['event_date'])) {
            $errors[] = "Termin Datum darf gültig sein.";
        }

        if (!empty($data['reminder_time']) &&
            !$this->isValidReminderTime($data['reminder_time'])) {
            $errors[] = "Reminder Time muss gültig sein.";
        }

        if (!empty($data['reminder_time'])) {

            if (!$this->eventDateGreaterThanReminderTime($data['event_date']
                                              ,$data['reminder_time'])) {
            $errors[] = 'Die Erinnerungszeit darf nicht nach dem Eventdatum liegen.';
            }
        }


        return $errors;

    }

    public function isValidEventDate(string $event_date) : bool {
        $standard_date = DateTime::CreateFromFormat('Y-m-d' , $event_date);
        return $standard_date &&
        $standard_date->format('Y-m-d') === $event_date;
    }

    public function isValidReminderTime(string $reminder_time) : bool {

        $formats = ['Y-m-d H:i:s', 'Y-m-d\TH:i', 'Y-m-d\TH:i:s'];

        foreach ($formats as $format) {
            $datetime = DateTime::createFromFormat($format , $reminder_time);
            if ($datetime && $datetime->format($format) === $reminder_time) {
                return true;
            }
        }
        
        return false;
    }

    public function eventDateGreaterThanReminderTime(string $event_date,
                                                     string $reminder_time) : bool {
        $std_event_date =DateTime::CreateFromFormat('Y-m-d' , $event_date);
        $std_reminder_date = 
        DateTime::CreateFromFormat('Y-m-d H:i:s', $reminder_time) ?: 
        DateTime::CreateFromFormat('Y-m-d\TH:i', $reminder_time);

        return $std_event_date > $std_reminder_date;
    }
    
}