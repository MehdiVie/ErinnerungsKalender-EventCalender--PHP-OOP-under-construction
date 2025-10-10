    <h3>Nuen Termin erstellen</h3>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php 
    if (empty($event)) {
        $event=[
            'title' => '' , 
            'description' => '', 
            'event_date' => '', 
            'reminder_time' => ''
        ];
    }
    ?>
    <form action="<?= BASE_URL ?>/events/store" method="post">

        <label for="title">Title:</label><br>
        <input type="text" name="title" id="title" value="<?=htmlspecialchars($event['title']) ?>" required><br><br>

        <label for="description">Description:</label><br>
        <textarea name="description" id="description" cols="40" rows="4"><?=htmlspecialchars($event['description']) ?></textarea><br><br>

        <label for="event_date">Datum:</label><br>
        <input type="date" name="event_date" id="event_date" value="<?=htmlspecialchars($event['event_date']) ?>" required><br><br>

        <label for="reminder_time">Erinnerungszeit: (optional)</label><br>
        <input type="datetime-local" name="reminder_time" id="reminder_time" value="<?=htmlspecialchars($event['reminder_time']) ?>"><br><br>

        <button type="submit" name="create_event">Speichern</button>
        <a href="<?= BASE_URL ?>/" class="btn btn-secondary">Zurück</a>
    </form>

    

