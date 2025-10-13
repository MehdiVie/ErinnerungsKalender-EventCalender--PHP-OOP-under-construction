

<h6 class="fw-semibold mb-3 text-dark">
Das MySQL-reminder ev_fill_reminder_queue ist dafür zuständig, die reminder_queue-Tabelle in der Datenbank automatisch zu füllen.
<br><br>
Das Skript cronReminder.php ist für die Verwaltung dieser Tabelle verantwortlich (z. B. für das Verarbeiten und Löschen der Erinnerungen)</h6>
<h6 class="fw-semibold mb-3 text-danger">
(Zum Ausführen des cronReminder.php-Skripts klicken Sie im Menü auf Run-Cron)</h6>
<div class="table-responsive mt-4 d-none d-md-block">
  <table id="reminders-table" class="table table-striped table-bordered align-middle text-center">
    <thead class="table-light">
      <tr>
        <th scope="col">Email</th>
        <th scope="col">Bezeichnung</th>
        <th scope="col">Erinnerungszeit</th>
        <th scope="col">Status</th>
        <th scope="col">Sent At</th>
        <!--<th scope="col">Attempts</th>-->
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($reminders)): ?>
        <?php foreach ($reminders as $reminder): ?>
          <?php if ($reminder["status"]=="sent") : ?>
            <tr class="table-success">
          <?php else : ?>
            <tr >
          <?php endif; ?>
            <td><?= htmlspecialchars($reminder["email"]) ?></td>
            <td><?= htmlspecialchars($reminder["title"]) ?></td>
            <td><?= htmlspecialchars($reminder["scheduled_at"]) ?></td>
            <td><?= htmlspecialchars($reminder["status"]) ?></td>
            <td><?= $reminder["sent_at"] ? htmlspecialchars($reminder["sent_at"]) : '-' ?></td>
            <!--<td><?= htmlspecialchars($reminder["attempts"]) ?></td>-->
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="5" class="text-muted">Kein Reminder in Queue.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Responsive Cards (for small screens) -->
<div class="d-md-none mt-3">
  <?php if (!empty($reminders)): ?>
    <?php foreach ($reminders as $reminder): ?>
      <div class="card mb-3 shadow-sm " >
        <?php if ($reminder["status"]=="sent"): ?>
        <div class="card-body card-status-sent">
        <?php else: ?>
        <div class="card-body">
        <?php endif; ?>
          <h6 class="card-title mb-2"><?= htmlspecialchars($reminder["email"]) ?></h6>
          <h6 class="card-title mb-2"><?= htmlspecialchars($reminder["title"]) ?></h6>
          <p class="card-text mb-1"><strong>Erinnerung:</strong> <?= htmlspecialchars($reminder["scheduled_at"]) ?></p>
          <p class="card-text mb-1"><?= htmlspecialchars($reminder["status"]) ?></p>
          <p class="card-text mb-3"><strong>Sent At:</strong> <?= $reminder["sent_at"] ? htmlspecialchars($reminder["sent_at"]) : '-' ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>