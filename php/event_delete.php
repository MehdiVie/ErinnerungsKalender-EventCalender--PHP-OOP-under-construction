<?php
require_once __DIR__ . "/session.php";
require_once __DIR__ . "/db_connect.php";


if (!isset($_SESSION["user_name"])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET["id"])) {

    $db=Database::getInstance();
    $event_id = (int)($_GET["id"]);

    $record = $db->prepare("SELECT id FROM events WHERE id = :event_id AND user_id = :user_id");

    $record->bindParam(':user_id', $_SESSION["user_id"]);
    $record->bindParam(':event_id', $event_id);
    $record->execute();
    $deleted_user=$record->fetch(PDO::FETCH_ASSOC);

    if($deleted_user) {

        $delete = $db->prepare("DELETE FROM events WHERE 
                                id = :event_id AND user_id = :user_id");
        $delete->bindParam(':user_id', $_SESSION["user_id"]);
        $delete->bindParam(':event_id', $event_id);
        $delete->execute();

        header('Location: events_list.php?delete=1');

    } else {
        echo "Zugriff verweigert oder Event existiert nicht.";
        exit();
    }

}