    <h2>Benutzer Login</h2>
    <?php if (isset($errors)): ?>
        <div class="alert alert-danger"><?= $errors ?? null ?></div>
    <?php endif; ?>
    <?php if (isset($message)): ?>
        <div class="alert alert-success"><?= $message ?? null ?></div>
    <?php endif; ?>
    <form action="<?= BASE_URL ?>/login" method="post">
        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email"><br><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password"><br><br>

        <button type="submit" name="login">Login</button>
    </form>