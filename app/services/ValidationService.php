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
        $tz = new DateTimeZone('Europe/Vienna');

        if (empty(trim($data['event_date']))) {
            $errors[] = "Datum darf nicht leer sein.";
        } else if (!$this->isValidEventDate($data['event_date'])) {

            $min_date = new DateTime('tomorrow', $tz);
            $min_date->setTime(0, 0, 0);

            $errors[] = "Datum darf mindestens ". $min_date->format('d.m.Y') ." liegen.";
        }

        if (empty(trim($data['title']))) {
            $errors[] = "Bezeichnung darf nicht leer sein.";
        }

        if (empty(trim($data['reminder_time'] ?? ''))) {
            $errors[] = "Erinnerungszeit darf nicht leer sein.(Datum und Zeit mussen festgelegt werden.)";
        } else if (!$this->isValidReminderTime($data['reminder_time'])) {

            $now = new DateTime('now', $tz);

            $errors[] = "Erinnerungszeit darf mindestens ". $now->format('Y-m-d H:i') . " liegen.";
        }
        
        if (!empty($data['event_date']) && !empty($data['reminder_time'])) {

            if (!$this->eventDateGreaterThanReminderTime($data['event_date']
                                              ,$data['reminder_time'])) {
            $errors[] = 'Erinnerungszeit darf maximal am Vortag des Datums liegen.(NICHT später)';
            }
        }


        return $errors;

    }

    public function isValidEventDate(string $event_date) : bool {
        $tz = new DateTimeZone('Europe/Vienna');

    
        $standard_date = DateTime::createFromFormat('Y-m-d', $event_date, $tz);
        if (!$standard_date || $standard_date->format('Y-m-d') !== $event_date) {
            return false;
        }

       
        $min_date = new DateTime('tomorrow', $tz);
        $min_date->setTime(0, 0, 0);

       
        return $standard_date >= $min_date;
    }

    public function isValidReminderTime(string $reminder_time) : bool {

        $tz = new DateTimeZone('Europe/Vienna');
        $formats = ['Y-m-d H:i:s', 'Y-m-d\TH:i', 'Y-m-d\TH:i:s'];
        $datetime = null;

            
        foreach ($formats as $format) {
            $dt = DateTime::createFromFormat($format, $reminder_time, $tz);
            if ($dt && $dt->format($format) === $reminder_time) {
                $datetime = $dt;
                break;
            }
        }

        if (!$datetime) {
            return false;
        }

        
        $now = new DateTime('now', $tz);
        //echo 'Now: '.$now->format('Y-m-d H:i').'<br>';
        //echo $datetime->format('Y-m-d H:i');
        //exit;

        return $datetime >= $now;
    }

    public function eventDateGreaterThanReminderTime(string $event_date,
                                                     string $reminder_time) : bool {
        $tz = new DateTimeZone('Europe/Vienna');
        $std_event_date =DateTime::CreateFromFormat('Y-m-d' , $event_date, $tz);
        $std_reminder_date = 
        DateTime::CreateFromFormat('Y-m-d H:i:s', $reminder_time, $tz) ?: 
        DateTime::CreateFromFormat('Y-m-d\TH:i', $reminder_time, $tz);

        if (!$std_event_date || !$std_reminder_date) {
            return false;
        }

        $event_day= $std_event_date->format('Y-m-d');
        $reminder_day = $std_reminder_date->format('Y-m-d');

        return $reminder_day < $event_day;

    }
    
}