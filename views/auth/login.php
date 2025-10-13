    <h2>Benutzer Login</h2>
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
        <label for="email">* Email:</label><br>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">* Password:</label><br>
        <input type="password" name="password" id="password" required><br><br>

        <button type="submit" name="login" class="btn btn-primary px-4">Login</button>
    </form>