  <?php  
    require_once __DIR__ . '/create.php';
  ?>
    
    <?php if (!empty($_SESSION['flash_message_delete'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['flash_message_delete']) ?></div>
    <?php 
    unset($_SESSION['flash_message_delete']);
    endif; ?>
    <?php if (!empty($_SESSION['flash_message_create'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['flash_message_create']) ?></div>
    <?php 
    unset($_SESSION['flash_message_create']);
    endif; ?>
    <?php if (!empty($_SESSION['flash_message_update'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['flash_message_update']) ?></div>
    <?php 
    unset($_SESSION['flash_message_update']);
    endif; ?>
    <?php if (!empty($_SESSION['flash_message_email'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['flash_message_email']) ?></div>
    <?php 
    unset($_SESSION['flash_message_email']);
    endif; ?>
    <table id="events-table" border="1" cellpadding="6">
        <thead>
            <tr>
                
                <!--<th>Beschreibung</th>-->
                <th>Datum</th>
                <th>Bezeichnung</th>
                <th>Erinnerung</th>
                <!--<th>Erstellt am</th>
                <th>Geändert am</th>-->
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($events): ?>
                <?php foreach ($events as $event): ?>
                
                <tr data-id="<?= $event['id'] ?>">
                    <td><?= htmlspecialchars($event["event_date"]) ?></td>
                    <td><?= htmlspecialchars($event["title"]) ?></td>
                    <!--<td><?= $event["description"] ? 
                        htmlspecialchars($event["description"]) : '-' ?></td>-->
                    
                    <td><?= $event["reminder_time"] ? 
                        htmlspecialchars($event["reminder_time"]) : '-' ?></td>
                    <!--<td><?= htmlspecialchars($event["created_at"]) ?></td>
                    <td><?= htmlspecialchars($event["updated_at"]) ?></td>-->
                    <td>
                        <button class="edit-btn btn btn-sm btn-warning">Bearbeiten</button>
                        <button class="delete-btn btn btn-sm btn-danger">Löschen</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
            <?php endif; ?>
        </tbody>
    </table>
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
          <div class="mb-3">
            <label for="edit-title" class="form-label">Titel</label>
            <input type="text" class="form-control" id="edit-title" name="title" required>
          </div>
          <div class="mb-3">
            <label for="edit-description" class="form-label">Beschreibung</label>
            <textarea class="form-control" id="edit-description" name="description"></textarea>
          </div>
          <div class="mb-3">
            <label for="edit-date" class="form-label">Datum</label>
            <input type="date" class="form-control" id="edit-date" name="event_date" required>
          </div>
          <div class="mb-3">
            <label for="edit-reminder" class="form-label">Erinnerung</label>
            <input type="datetime-local" class="form-control" id="edit-reminder" name="reminder_time" >
          </div>
          <button type="submit" class="btn btn-primary">Speichern</button>
        </form>
      </div>
    </div>
  </div>
</div>

    