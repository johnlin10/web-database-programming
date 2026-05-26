<?php
// On Railway, env vars are injected automatically — skip .env to avoid overwriting them.
// Locally, RAILWAY_ENVIRONMENT is not set, so .env is loaded instead.
if (!getenv('RAILWAY_ENVIRONMENT')) {
    $envFile = __DIR__ . '/.env';
    if (file_exists($envFile)) {
        foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if (str_starts_with(trim($line), '#')) continue;
            [$key, $val] = explode('=', $line, 2) + [1 => ''];
            putenv(trim($key) . '=' . trim($val));
        }
    }
}

define('DB_HOST', getenv('MYSQLHOST')     ?: 'localhost');
define('DB_USER', getenv('MYSQLUSER')     ?: 'root');
define('DB_PASS', getenv('MYSQLPASSWORD') ?: '');
