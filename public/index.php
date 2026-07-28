<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Auto-clear stale Windows route/config/view caches for shared hosting compatibility
@unlink(__DIR__.'/../bootstrap/cache/config.php');
@unlink(__DIR__.'/../bootstrap/cache/routes-v7.php');

$viewsDir = __DIR__.'/../storage/framework/views';
if (is_dir($viewsDir)) {
    foreach (glob($viewsDir.'/*.php') as $file) {
        @unlink($file);
    }
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
