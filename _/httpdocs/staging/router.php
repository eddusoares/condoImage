<?php
// Simple router for PHP's built-in server.
// Serves existing files directly; otherwise boots the app via index.php.

if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $path;
    if ($path !== '/' && is_file($file)) {
        // Let the built-in server handle existing files (assets, images, etc.).
        return false;
    }
}

require __DIR__ . '/index.php';

