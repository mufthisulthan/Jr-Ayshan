<?php

declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/storage.php';

if (!function_exists('jr_asset')) {
    function jr_asset(string $path): string
    {
        return 'assets/' . ltrim($path, '/');
    }
}

if (!function_exists('jr_link')) {
    function jr_link(string $path): string
    {
        return preg_replace('/\.html(\?[^#]*)?(#.*)?$/', '.php$1$2', $path) ?? $path;
    }
}

if (!function_exists('jr_page_slug')) {
    function jr_page_slug(): string
    {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $slug = basename($scriptName, '.php');

        return $slug === 'index' ? 'dashboard' : $slug;
    }
}
