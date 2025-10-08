<?php
require_once __DIR__ . '/../core/Model.php';

class Event extends Model {
    public function findAll() {
        return $this->query("SELECT * FROM events")->fetchAll(PDO::FETCH_ASSOC);
    }
}
