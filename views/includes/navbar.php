
<?php if (isset($_SESSION['user_name'])): ?>
    <div class="small mb-4">
        Eingeloggt als <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>
    </div>
<?php endif; ?>

<div class="d-flex flex-column gap-2">
    <a href="<?= BASE_URL ?>/home" class="btn btn-secondary btn-outline-light mb-2 w-100 text-start"><i class="bi bi-house"></i> Home</a>
  
  <?php if (!isset($_SESSION['user_name'])): ?>
    <a href="<?= BASE_URL ?>/login" class="btn btn-secondary btn-outline-light mb-2 w-100 text-start"><i class="bi bi-box-arrow-in-right"></i> Login</a>
    <a href="<?= BASE_URL ?>/register" class="btn btn-secondary btn-outline-light mb-2 w-100 text-start"><i class="bi bi-person-plus"></i> Registrieren</a>
  <?php else: ?>
    <a href="<?= BASE_URL ?>/" class="btn btn-secondary btn-outline-light mb-2 w-100 text-start"><i class="bi bi-calendar-check"></i> Termin Liste</a>
    <!--<a href="<?= BASE_URL ?>/events/create" class="btn btn-secondary btn-outline-light mb-2 w-100 text-start"><i class="bi bi-plus-circle"></i> Neuer Termin</a>-->
    <a href="<?= BASE_URL ?>/logout" class="btn btn-secondary btn-outline-light mb-2 w-100 text-start"><i class="bi bi-box-arrow-right"></i> Logout</a>
    <a href="<?= BASE_URL ?>/run-cron" class="btn btn-secondary btn-outline-light mb-2 w-100 text-start mt-4">
    <i class="bi bi-radioactive"></i> Cron Reminder</a>
  <?php endif; ?>

</div>
