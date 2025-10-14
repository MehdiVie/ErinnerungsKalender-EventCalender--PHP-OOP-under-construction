<?php if (!empty($_SESSION['flash_message_cron'])): ?>
    <div class="alert alert-info"><?= htmlspecialchars($_SESSION['flash_message_cron']) ?></div>
    <?php 
    unset($_SESSION['flash_message_cron']);
endif; ?>

<div class="alert shadow-sm mt-1" role="alert">
  <h5 class="fw-semibold text-primary mb-2">
    <i class="bi bi-info-circle me-2"></i> Information über das Reminder-System
  </h5>
  <p class="mb-2 text-dark">
    Das MySQL-Event <code>ev_fill_reminder_queue</code> ist dafür zuständig, 
    die Tabelle <code>reminder_queue</code> automatisch mit fälligen Erinnerungen zu füllen.
  </p>
  <p class="mb-2 text-dark">
    Das Skript <code>cronReminder.php</code> ist für die Verwaltung dieser Tabelle verantwortlich – 
    es verarbeitet und löscht gesendete Erinnerungen.
  </p>
  <p class="fw-semibold text-danger mb-0">
    <i class="bi bi-play-circle"></i>
    Zum manuellen Ausführen klicken Sie im Menü auf 
    <strong>Run-Cron</strong>.
  </p>
</div>

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