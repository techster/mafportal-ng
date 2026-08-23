<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/') {
    $publicPath = __DIR__.'/public'.$uri;

    if (is_file($publicPath)) {
        $mimeTypes = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'svg' => 'image/svg+xml',
            'html' => 'text/html',
            'txt' => 'text/plain',
        ];
        $extension = strtolower(pathinfo($publicPath, PATHINFO_EXTENSION));
        $mimeType = isset($mimeTypes[$extension])
            ? $mimeTypes[$extension]
            : (function_exists('mime_content_type') ? mime_content_type($publicPath) : 'application/octet-stream');

        header('Content-Type: '.$mimeType);
        readfile($publicPath);
        return true;
    }
}

require_once __DIR__.'/public/index.php';
