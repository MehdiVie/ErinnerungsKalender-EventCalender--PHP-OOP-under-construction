<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Erinnerungskalender</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

  <?php include __DIR__ . '/../includes/header.php'; ?>

  <div class="container-fluid flex-grow-1 px-0">
    <div class="row g-0 justify-content-center">

      <!-- Sidebar (nur Desktop sichtbar) -->
      <aside class="col-md-2 bg-secondary text-white p-3 sidebar d-none d-md-block">
        <?php include __DIR__ . '/../includes/navbar.php'; ?>
      </aside>

      <!-- Hauptinhalt -->
      <main class="col-12 col-md-8 bg-white shadow-sm p-4 main-content">
        <?php include $viewFile; ?>
      </main>

      <!-- Rechte Spalte als Platzhalter -->
      <div class="d-none d-md-block col-md-2 bg-secondary"></div>

    </div>
  </div>

  <?php include __DIR__ . '/../includes/footer.php'; ?>

  <script>
    const BASE_URL = "<?= BASE_URL ?>";
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= BASE_URL ?>/js/main.js"></script>
</body>
</html>
