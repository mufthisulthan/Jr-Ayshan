<?php

declare(strict_types=1);

function jr_env(string $key, mixed $default = null): mixed
{
    $value = getenv($key);
    if ($value === false || $value === '') {
        return $default;
    }

    return $value;
}

function jr_db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    // Optional local config file that returns an array with keys:
    // host, port, name, user, pass (any key names DB_HOST/DB_NAME accepted)
    $localFile = __DIR__ . '/database.local.php';
    $local = [];
    if (file_exists($localFile)) {
        $maybe = require $localFile;
        if (is_array($maybe)) {
            $local = $maybe;
        }
    }

    $host = (string) ($local['host'] ?? $local['DB_HOST'] ?? jr_env('DB_HOST', '127.0.0.1'));
    $port = (string) ($local['port'] ?? $local['DB_PORT'] ?? jr_env('DB_PORT', '3306'));
    $name = (string) ($local['name'] ?? $local['DB_NAME'] ?? jr_env('DB_NAME', 'jr_marketing'));
    $user = (string) ($local['user'] ?? $local['DB_USER'] ?? jr_env('DB_USER', 'root'));
    $pass = (string) ($local['pass'] ?? $local['DB_PASS'] ?? jr_env('DB_PASS', ''));

    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $name);

    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $pdo;
}
