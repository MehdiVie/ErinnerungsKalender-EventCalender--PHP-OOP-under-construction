<?php
require_once __DIR__ . '/load_env.php';
loadEnv(__DIR__ . '/../.env');

echo "<h3>Test .env</h3>";
echo "<p>APP_ENV: " . getenv('APP_ENV') . "</p>";
echo "<p>DB_HOST: " . getenv('DB_HOST') . "</p>";
echo "<p>DB_NAME: " . getenv('DB_NAME') . "</p>";
