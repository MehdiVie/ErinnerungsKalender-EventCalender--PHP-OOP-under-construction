<header class="bg-light border-bottom shadow-sm sticky-top text-center py-2 mt-3">

    <a class="navbar-brand text-primary fw-semibold text-center mx-auto " href="<?= BASE_URL ?>/">
      <img src="<?= BASE_URL ?>/images/logo.png" 
       style="height:55px; object-fit:contain;">
    </a>

<nav class="navbar navbar-expand-md navbar-light bg-white mt-2">
  <div class="container justify-content-center">

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav d-md-none ms-auto mb-2 mb-md-0">
          <li class="nav-item"><a href="<?= BASE_URL ?>/home" class="nav-link"><i class="bi bi-house"></i> Home</a></li>
        <?php if (!isset($_SESSION['user_name'])): ?>
          <li class="nav-item"><a href="<?= BASE_URL ?>/login" class="nav-link"><i class="bi bi-box-arrow-in-right"></i> Login</a></li>
          <li class="nav-item"><a href="<?= BASE_URL ?>/register" class="nav-link"><i class="bi bi-person-plus"></i> Registrieren</a></li>
        <?php else: ?>
          <li class="nav-item"><a href="<?= BASE_URL ?>/" class="nav-link"><i class="bi bi-calendar-check"></i> Termine</a></li>
          <!--<li class="nav-item"><a href="<?= BASE_URL ?>/events/create" class="nav-link"><i class="bi bi-plus-circle"></i> Neuer Termin</a></li>-->
          <li class="nav-item"><a href="<?= BASE_URL ?>/reminders" class="nav-link"><i class="bi bi-radioactive"></i> Emails Queue</a></li>
          <li class="nav-item"><a href="<?= BASE_URL ?>/run-cron" class="nav-link"><i class="bi bi-radioactive"></i> Run-Cron</a></li>
          <li class="nav-item"><a href="<?= BASE_URL ?>/logout" class="nav-link"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        <?php endif; ?>
      </ul>
      </div>
    </div>
  </nav>
</header>

