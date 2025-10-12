
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
    <div class="d-flex justify-content-center border border-dark p-4">
        

            <div class="m-3">
                <label for="event_date">Datum</label><br>
                <input type="date" name="event_date" id="event_date" value="<?=htmlspecialchars($event['event_date']) ?>" required><br><br>
            </div>
            <!--
            <label for="description">Description:</label><br>
            <textarea name="description" id="description" cols="40" rows="4"><?=htmlspecialchars($event['description']) ?></textarea><br><br>-->

            
            <div class="m-3">
                <label for="title">Bezeichnung</label><br>
                <input type="text" name="title" id="title" value="<?=htmlspecialchars($event['title']) ?>" required><br><br>
            </div>

            <div class="m-3">
                <label for="reminder_time">Erinnerungszeit</label><br>
                <input type="datetime-local" name="reminder_time" id="reminder_time" value="<?=htmlspecialchars($event['reminder_time']) ?>"><br><br>
            </div>

            <div class="d-flex align-items-center m-3">
                <button type="submit" name="create_event" class="btn btn-success">Speichern</button>
                
            </div>

        
    </div>
    </form>

    

