<?php
require_once __DIR__ . "/../core/Model.php";

class EventRepository extends Model {

    public function getAllByUser(int $user_id) : ?array {
        $sql = "select * from events where user_id = :user_id ";
        $res = $this->query($sql , [":user_id"=>$user_id]);
        $events = $res->fetchAll(PDO::FETCH_ASSOC);
        return $events?:null;
    }

    public function findById(int $event_id) : ?array {
        $sql = "select * from events where id = :event_id AND user_id=:user_id";
        $res = $this->query($sql , [":event_id"=>$event_id , ":user_id"=>$_SESSION["user_id"]]);
        $event = $res->fetch(PDO::FETCH_ASSOC);
        return $event?:null;
    }

    public function create(array $data) : bool {
        $sql = "insert into events 
            (user_id, title, description, event_date , reminder_time)
               values
            (:user_id, :title, :description, :event_date , :reminder_time)";
        $res = $this->query($sql , [
            ":user_id" => $data["user_id"] ,
            ":title" => $data["title"] ,
            ":description" => $data["description"] ?? "" ,
            ":event_date" => $data["event_date"] ,
            ":reminder_time" => $data["reminder_time"] ?? null
        ]);
        return $res->rowCount() > 0 ;
    }

    public function update(int $event_id , array $data) : bool {
        $sql = "update events set
            title = :title, description = :description, 
            event_date = :event_date , reminder_time = :reminder_time ,
            notified = 0, notified_at = NULL
            where id=:event_id AND user_id=:user_id";
        $res = $this->query($sql , [
            ":event_id" => $event_id ,
            ":user_id" => $data["user_id"] ,
            ":title" => $data["title"] ,
            ":description" => $data["description"] ?? "" ,
            ":event_date" => $data["event_date"] ,
            ":reminder_time" => $data["reminder_time"] ?? null
        ]);
        return $res->rowCount() > 0 ;
    }



    public function delete(int $event_id , int $user_id) : bool {
        $sql = "delete from events  
            where id=:event_id AND user_id=:user_id";
        $res = $this->query($sql , [
            ":event_id" => $event_id ,
            ":user_id" => $user_id 
        ]);
        return $res->rowCount() > 0 ;
    }
}