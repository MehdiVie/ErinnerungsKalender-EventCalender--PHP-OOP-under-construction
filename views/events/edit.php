    <h3>Termin Bearbeiten</h3>
    <?php if (isset($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?= BASE_URL ?>/events/update" method="post">

        <label for="title">Title:</label><br>
        <input type="text" name="title" id="title" value="<?=htmlspecialchars($event['title']) ?>"><br><br>

        <label for="description">Description:</label><br>
        <textarea name="description" id="description" cols="40" rows="4"><?=htmlspecialchars($event['description']) ?></textarea><br><br>

        <label for="event_date">Datum:</label><br>
        <input type="date" name="event_date" id="event_date" value="<?=htmlspecialchars($event['event_date']) ?>"><br><br>

        <label for="reminder_time">Erinnerungszeit: (optional)</label><br>
        <input type="datetime-local" name="reminder_time" id="reminder_time" value="<?=htmlspecialchars($event['reminder_time']) ?>"><br><br>

        <input type="hidden" name="event_id" id="event_id" value="<?=$event['id'] ?>">

        <button type="submit" name="update_event">Bearbeiten</button>
        <a href="<?= BASE_URL ?>/" class="btn btn-secondary">Zurück</a>
    </form>
