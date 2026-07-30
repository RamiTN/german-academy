<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/toinfinity/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Auto-clear stale Windows route/config/view caches for shared hosting compatibility
@unlink(__DIR__.'/toinfinity/bootstrap/cache/config.php');
@unlink(__DIR__.'/toinfinity/bootstrap/cache/routes-v7.php');

$viewsDir = __DIR__.'/toinfinity/storage/framework/views';
if (is_dir($viewsDir)) {
    foreach (glob($viewsDir.'/*.php') as $file) {
        @unlink($file);
    }
}

// Register the Composer autoloader...
require __DIR__.'/toinfinity/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/toinfinity/bootstrap/app.php';

// Ensure Laravel knows the public path is actually the current directory (htdocs)
$app->usePublicPath(__DIR__);

$app->handleRequest(Request::capture());
