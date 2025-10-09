    <h3>Meine Termine</h3>
    <?php if (!empty($_SESSION['flash_message'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['flash_message']) ?>
        </div>
        <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>
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
                    <td><?= $event["description"] ? 
                        htmlspecialchars($event["description"]) : '-' ?></td>
                    <td><?= htmlspecialchars($event["event_date"]) ?></td>
                    <td><?= $event["reminder_time"] ? 
                        htmlspecialchars($event["reminder_time"]) : '-' ?></td>
                    <td><?= htmlspecialchars($event["created_at"]) ?></td>
                    <td><?= htmlspecialchars($event["updated_at"]) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/events/edit?id=<?=$event["id"] ?>" ">Bearbeiten</a>
                        <a href="<?= BASE_URL ?>/events/delete?id=<?=$event["id"] ?>" onclick="return confirm('Bist du sicher?');">Löchen</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
            <?php endif; ?>
        </tbody>
    </table>