    <h3 class="fw-semibold mb-3 text-dark">Benutzer Login</h3>
    <?php if (isset($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if (!empty($message)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form action="<?= BASE_URL ?>/login" method="post">
        <label for="email">* Email</label><br>
        <input type="email" name="email" id="email" class="form-label fw-semibold" required><br><br>

        <label for="password">* Password</label><br>
        <input type="password" name="password" id="password" class="form-label fw-semibold" required><br><br>

        <button type="submit" name="login" class="btn btn-primary px-4">Login</button>
    </form>