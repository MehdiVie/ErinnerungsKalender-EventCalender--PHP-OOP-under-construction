<?php
require_once __DIR__ . "/session.php";
require_once __DIR__ . "/db_connect.php";
require_once __DIR__ . '/../config/paths.php';

if (!isset($_SESSION["user_name"])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION["user_id"];
[$title , $description , $event_date , $reminder_time]=["","","",""];
$message="";
$db=Database::getInstance();

if (isset($_GET["id"])) {
    // set event_id came from events_list.php
    $event_id = (int)$_GET["id"];

    // search in events db-table for this specific event_id
    $record = $db->prepare("SELECT id, title, description, event_date,     reminder_time FROM events WHERE id = :event_id AND user_id = :user_id");

    $record->bindParam(':user_id', $_SESSION["user_id"]);
    $record->bindParam(':event_id', $event_id);
    $record->execute();
    $updated_user=$record->fetch(PDO::FETCH_ASSOC);

    // check if this specific event found?
    if($updated_user) {
        $title = $updated_user["title"];
        $description = $updated_user["description"];
        $event_date=$updated_user["event_date"];
        $reminder_time=$updated_user["reminder_time"];
    } else {
        $message = "Es gibt kein Event mit diesem ID";
    }
}
if (isset($_POST["update_event"]) && $_SERVER['REQUEST_METHOD']==='POST') {

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $event_date=$_POST["event_date"];
    $reminder_time=$_POST["reminder_time"] ? : null;
    $event_id=$_POST["event_id"];

    if($title && $event_date) {
        $record = $db->prepare("update events set 
                                title = :title , description = :description ,
                                event_date = :event_date ,
                                reminder_time = :reminder_time 
                                where user_id = :user_id AND id = :event_id ");

        $record->bindParam(':user_id',$user_id);
        $record->bindParam(':event_id', $event_id);
        $record->bindParam(':title',$title);
        $record->bindParam(':description',$description);
        $record->bindParam(':event_date',$event_date);
        $record->bindParam(':reminder_time',$reminder_time);

        if ($record->execute()) {
            $message = "Termin wurde erfolgreich bearbeitet.";
            header('Location: events_list.php');
        } else{
            $message = "Fehler beim Bearbeiten des Termins.";
        }
    }

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event bearbeiten</title>
    <?php require_once INCLUDES_PATH . '/header.php'; ?>
</head>
<body>
    <?php require_once INCLUDES_PATH . '/navbar.php'; ?>
    <h3>Event bearbeiten</h3>

    <?php if (!empty($message)): ?>
        <p><?=htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form action="" method="post">

        <label for="title">Title:</label><br>
        <input type="text" name="title" id="title" value="<?=htmlspecialchars($title) ?>"><br><br>

        <label for="description">Description:</label><br>
        <textarea name="description" id="description" cols="40" rows="4"><?=htmlspecialchars($description) ?></textarea><br><br>

        <label for="event_date">Datum:</label><br>
        <input type="date" name="event_date" id="event_date" value="<?=htmlspecialchars($event_date) ?>"><br><br>

        <label for="reminder_date">Erinnerungszeit: (optional)</label><br>
        <input type="datetime-local" name="reminder_time" id="reminder_time" value="<?=htmlspecialchars($reminder_time) ?>"><br><br>

        <input type="hidden" name="event_id" id="event_id" value="<?=$event_id ?>">

        <button type="submit" name="update_event">Bearbeiten</button>

    </form>

    <p><a href="events_list.php">Zurück zur Terminliste</a></p>
    <?php require_once INCLUDES_PATH . '/footer.php'; ?>
</body>
</html>