<?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach ($errors as $error): ?>
        <li><?= htmlspecialchars($error) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<?php 
if (empty($event)) {
  $event = [
    'title' => '', 
    'description' => '', 
    'event_date' => '', 
    'reminder_time' => ''
  ];
}
?>

<div class="card shadow-sm mt-3">
  <div class="card-body">

    <form action="<?= BASE_URL ?>/events/store" method="post" class="needs-validation" >
      <div class="row g-3">

        <!-- Datum -->
        <div class="col-12 col-md-4">
          <label for="event_date" class="form-label fw-semibold">Datum</label>
          <input type="date" name="event_date" id="event_date" 
                 value="<?= htmlspecialchars($event['event_date']) ?>" 
                 class="form-control" required>
          <div class="invalid-feedback">Bitte ein Datum eingeben.</div>
        </div>

        <!-- Bezeichnung -->
        <div class="col-12 col-md-4">
          <label for="title" class="form-label fw-semibold">Bezeichnung</label>
          <input type="text" name="title" id="title" 
                 value="<?= htmlspecialchars($event['title']) ?>" 
                 class="form-control" required>
          <div class="invalid-feedback">Bitte Bezeichnung eingeben.</div>
        </div>

        <!-- Erinnerungszeit -->
        <div class="col-12 col-md-4">
          <label for="reminder_time" class="form-label fw-semibold">Erinnerungszeit</label>
          <input type="datetime-local" name="reminder_time" id="reminder_time" 
                 value="<?= htmlspecialchars($event['reminder_time']) ?>" 
                 class="form-control"  required>
           <div class="invalid-feedback">Bitte Erinnerungszeit eingeben.</div>
        </div>

        <!-- Beschreibung (optional, wenn du es später zeigen willst) -->
        <!--
        <div class="col-12">
          <label for="description" class="form-label fw-semibold">Beschreibung</label>
          <textarea name="description" id="description" rows="3" 
                    class="form-control"><?= htmlspecialchars($event['description']) ?></textarea>
        </div>
        -->

        <!-- Submit Button -->
        <div class="col-12 text-center mt-3">
          <button type="submit" name="create_event" class="btn btn-success px-4">
            <i class="bi bi-save"></i> Speichern
          </button>
        </div>

      </div>
    </form>
  </div>
</div>
