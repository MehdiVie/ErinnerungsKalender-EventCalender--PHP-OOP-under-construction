<?php
require_once __DIR__ . "/session.php";
require_once __DIR__ . "/db_connect.php";

if (!isset($_SESSION["user_name"])) {
    header('Location: login.php');
    exit;
}

$db=Database::getInstance();

$records= $db->prepare("select * from events where user_id = :user_id");
$records->bindParam(':user_id', $_SESSION["user_id"]);
$records->execute();
$events=$records->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meine Termine</title>
</head>
<body>
    <h3>Meine Termine</h3>

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>Titel</th>
                <th>Beschreibung</th>
                <th>Datum</th>
                <th>Erinnerung</th>
                <th>Erstellt am</th>
                <th>Geändert am</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($events): ?>
                <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= htmlspecialchars($event["title"]) ?></td>
                    <td><?= nl2br(htmlspecialchars($event["description"])) ?>
                    </td>
                    <td><?= htmlspecialchars($event["event_date"]) ?></td>
                    <td><?= htmlspecialchars($event["reminder_time"]) ?></td>
                    <td><?= htmlspecialchars($event["created_at"]) ?></td>
                    <td><?= htmlspecialchars($event["updated_at"]) ?></td>
                    <td>
                        <a href="event_edit.php?id=<?=$event["id"] ?>">Bearbeiten</a>
                        <a href="event_delete.php?id=<?=$event["id"] ?>" onclick="return confirm('Bist du sicher?');">Löchen</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>