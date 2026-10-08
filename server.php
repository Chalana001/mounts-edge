<?php

/**
 * Router for PHP's built-in web server.
 *
 * Laravel's own router resolves the document root with getcwd(), which is the
 * project root when the server is launched from here, so it is replaced with an
 * explicit path. Emulates Apache's mod_rewrite: existing files are served as-is
 * and everything else is handed to the front controller.
 */
$publicPath = __DIR__.'/public';

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

if ($uri !== '/' && file_exists($publicPath.$uri)) {
    return false;
}

require_once $publicPath.'/index.php';
