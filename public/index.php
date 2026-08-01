<?php
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Maintenance mode
if (file_exists($maintenance = __DIR__ . '/toinfinity/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Composer autoloader
require __DIR__ . '/toinfinity/vendor/autoload.php';

// Bootstrap Laravel
/** @var Application $app */
$app = require_once __DIR__ . '/toinfinity/bootstrap/app.php';

// Handle request
$app->handleRequest(Request::capture());