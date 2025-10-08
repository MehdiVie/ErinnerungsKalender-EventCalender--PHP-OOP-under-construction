    <h3>Nuen Termin erstellen</h3>


    <form action="<?= BASE_URL ?>/events/store" method="post">

        <label for="title">Title:</label><br>
        <input type="text" name="title" id="title"><br><br>

        <label for="description">Description:</label><br>
        <textarea name="description" id="description" cols="40" rows="4"></textarea><br><br>

        <label for="event_date">Datum:</label><br>
        <input type="date" name="event_date" id="event_date"><br><br>

        <label for="reminder_time">Erinnerungszeit: (optional)</label><br>
        <input type="datetime-local" name="reminder_time" id="reminder_time"><br><br>

        <button type="submit" name="create_event">Speichern</button>

    </form>

    

