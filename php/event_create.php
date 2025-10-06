<?php
require_once __DIR__ . "/session.php";
require_once __DIR__ . "/db_connect.php";

if (!isset($_SESSION["user_name"])) {
    header('Location: login.php');
    exit();
}

$message="";
$db=Database::getInstance();

if (isset($_POST["create_event"]) && $_SERVER['REQUEST_METHOD']==='POST') {

    $user_id = $_SESSION["user_id"];
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $event_date=$_POST["event_date"];
    $reminder_time=$_POST["reminder_time"] ? : null;

    if($title && $event_date) {
        $record = $db->prepare("insert into events 
        (user_id,title,description,event_date,reminder_time) 
        values 
        (:user_id,:title,:description,:event_date,:reminder_time)");

        $record->bindParam(':user_id',$user_id);
        $record->bindParam(':title',$title);
        $record->bindParam(':description',$description);
        $record->bindParam(':event_date',$event_date);
        $record->bindParam(':reminder_time',$reminder_time);

        if ($record->execute()) {
            $message = "Termin wurde erfolgreich erstellt.";
        } else{
            $message = "Fehler beim Erstellen des Termins.";
        }
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuen Termin erstellen</title>
</head>
<body>
    <h3>Nuen Termin erstellen</h3>

    <?php if (!empty($message)): ?>
        <p><?=htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form action="" method="post">

        <label for="title">Title:</label><br>
        <input type="text" name="title" id="title"><br><br>

        <label for="description">Description:</label><br>
        <textarea name="description" id="description" cols="40" rows="4"></textarea><br><br>

        <label for="event_date">Datum:</label><br>
        <input type="date" name="event_date" id="event_date"><br><br>

        <label for="reminder_date">Erinnerungszeit: (optional)</label><br>
        <input type="datetime-local" name="reminder_time" id="reminder_time"><br><br>

        <button type="submit" name="create_event">Speichern</button>

    </form>

    <p><a href="events_list.php">Zurück zur Terminliste</a></p>
</body>
</html>