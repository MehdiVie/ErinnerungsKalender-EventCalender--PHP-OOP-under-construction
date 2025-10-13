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
            $min_date = new DateTime('today', $tz);
            $min_date->add(new DateInterval('P1D'));
            $errors[] = "Datum muss mindestens ". $min_date->format('d.m.Y') ." liegen.";
        }

        if (empty(trim($data['title']))) {
            $errors[] = "Bezeichnung darf nicht leer sein.";
        }

        if (empty(trim($data['reminder_time'] ?? ''))) {
            $errors[] = "Erinnerungszeit darf nicht leer sein.(Datum und Zeit mussen festgelegt werden.)";
        } else if (!$this->isValidReminderTime($data['reminder_time'])) {
            $minDateTime = new DateTime('today', $tz);
            $errors[] = "Das Erinnerungszeit darf mindestens ". $minDateTime->format('d.m.Y') . " liegen.";
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
        $standard_date = DateTime::CreateFromFormat('Y-m-d' , $event_date);
        if (!$standard_date || $standard_date->format('Y-m-d') !== $event_date) {
            return false;
        }
        $tz = new DateTimeZone('Europe/Vienna');
        $standard_date = DateTime::createFromFormat('Y-m-d', $event_date, $tz);
        $min_date = new DateTime('today', $tz);
        $min_date->add(new DateInterval('P1D'));

        //echo $standard_date->format('Y-m-d')."<br>";
        //echo $min_date->format('Y-m-d')."<br>";
        //exit;
        return $standard_date >= $min_date;
    }

    public function isValidReminderTime(string $reminder_time) : bool {

        $formats = ['Y-m-d H:i:s', 'Y-m-d\TH:i', 'Y-m-d\TH:i:s'];
        $tz = new DateTimeZone('Europe/Vienna');
        $datetime = null;

        foreach ($formats as $format) {
            $dt = DateTime::createFromFormat($format, $reminder_time, $tz);
            if ($dt && $dt->format($format) === $reminder_time) {
                $datetime = $dt;
                break;
            }
        }

        $minDateTime = new DateTime('today', $tz);
        return $datetime >= $minDateTime;
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