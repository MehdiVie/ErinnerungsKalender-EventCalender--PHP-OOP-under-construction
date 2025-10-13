  <?php  
    require_once __DIR__ . '/create.php';
  ?>
    
    <?php if (!empty($_SESSION['flash_message_create'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['flash_message_create']) ?></div>
    <?php 
    unset($_SESSION['flash_message_create']);
    endif; ?>
    <?php if (!empty($_SESSION['flash_message_email'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['flash_message_email']) ?></div>
    <?php 
    unset($_SESSION['flash_message_email']);
    endif; ?>



<div class="table-responsive mt-4">
  <table id="events-table" class="table table-striped table-bordered align-middle text-center">
    <thead class="table-light">
      <tr>
        <th scope="col">Datum</th>
        <th scope="col">Bezeichnung</th>
        <th scope="col">Erinnerung</th>
        <th scope="col">Aktionen</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($events)): ?>
        <?php foreach ($events as $event): ?>
          <tr data-id="<?= $event['id'] ?>">
            <td><?= htmlspecialchars($event["event_date"]) ?></td>
            <td><?= htmlspecialchars($event["title"]) ?></td>
            <td><?= $event["reminder_time"] ? htmlspecialchars($event["reminder_time"]) : '-' ?></td>
            <td>
              <div class="d-flex flex-wrap justify-content-center gap-2">
                <button class="edit-btn btn btn-sm btn-warning">
                  <i class="bi bi-pencil"></i> Bearbeiten
                </button>
                <button class="delete-btn btn btn-sm btn-danger">
                  <i class="bi bi-trash"></i> Löschen
                </button>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="4" class="text-muted">Keine Termine gefunden.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>


<!-- Responsive Cards (for small screens) -->
<div class="d-md-none mt-3">
  <?php if (!empty($events)): ?>
    <?php foreach ($events as $event): ?>
      <div class="card mb-3 shadow-sm" data-id="<?= $event['id'] ?>">
        <div class="card-body">
          <h5 class="card-title mb-2"><?= htmlspecialchars($event["title"]) ?></h5>
          <p class="card-text mb-1"><strong>Datum:</strong> <?= htmlspecialchars($event["event_date"]) ?></p>
          <p class="card-text mb-3"><strong>Erinnerung:</strong> <?= $event["reminder_time"] ? htmlspecialchars($event["reminder_time"]) : '-' ?></p>
          <div class="d-flex gap-2">
            <button class="edit-btn btn btn-sm btn-warning flex-fill">
              <i class="bi bi-pencil"></i> Bearbeiten
            </button>
            <button class="delete-btn btn btn-sm btn-danger flex-fill">
              <i class="bi bi-trash"></i> Löschen
            </button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
    <!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Event bearbeiten</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editForm">
          <input type="hidden" name="id" id="edit-id">
          <!--<div class="mb-3">
            <label for="edit-description" class="form-label">Beschreibung</label>
            <textarea class="form-control" id="edit-description" name="description"></textarea>
          </div>-->
          <div class="mb-3">
            <label for="edit-date" class="form-label">Datum</label>
            <input type="date" class="form-control" id="edit-date" name="event_date" required>
          </div>
          <div class="mb-3">
            <label for="edit-title" class="form-label">Bezeichnung</label>
            <input type="text" class="form-control" id="edit-title" name="title" required>
          </div>
          <div class="mb-3">
            <label for="edit-reminder" class="form-label">Erinnerung</label>
            <input type="datetime-local" class="form-control" id="edit-reminder" name="reminder_time" required>
          </div>
          <button type="submit" class="btn btn-primary">Speichern</button>
        </form>
      </div>
    </div>
  </div>
</div>

    