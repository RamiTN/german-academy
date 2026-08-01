<?php
// Diagnostic script for InfinityFree
// Access this at: https://germanacademy.page.gd/test.php

echo "<h1>InfinityFree Diagnostic</h1>";

// 1. PHP Version
echo "<h2>1. PHP Version</h2>";
echo "<p>PHP Version: <strong>" . phpversion() . "</strong></p>";
$ok = version_compare(PHP_VERSION, '8.2.0', '>=');
echo $ok ? "<p style='color:green'>✅ PHP 8.2+ OK</p>" : "<p style='color:red'>❌ FAIL: Laravel 11 requires PHP 8.2+. Current: " . PHP_VERSION . "</p>";

// 2. Required Extensions
echo "<h2>2. Required PHP Extensions</h2>";
$exts = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'fileinfo', 'bcmath'];
foreach ($exts as $ext) {
    $loaded = extension_loaded($ext);
    echo $loaded 
        ? "<p style='color:green'>✅ $ext loaded</p>" 
        : "<p style='color:red'>❌ $ext MISSING</p>";
}

// 3. File Structure
echo "<h2>3. File Structure</h2>";
$checks = [
    '../vendor/autoload.php' => 'vendor/autoload.php (Composer dependencies)',
    '../bootstrap/app.php' => 'bootstrap/app.php',
    '../.env' => '.env file',
    '../storage/framework/views' => 'storage/framework/views/',
    '../storage/framework/sessions' => 'storage/framework/sessions/',
    '../storage/framework/cache' => 'storage/framework/cache/',
    '../storage/logs' => 'storage/logs/',
];
foreach ($checks as $path => $label) {
    $exists = file_exists(__DIR__ . '/' . $path);
    echo $exists 
        ? "<p style='color:green'>✅ $label exists</p>" 
        : "<p style='color:red'>❌ $label MISSING</p>";
}

// 4. Storage Writable
echo "<h2>4. Storage Permissions</h2>";
$dirs = ['../storage', '../storage/framework/views', '../storage/logs', '../bootstrap/cache'];
foreach ($dirs as $dir) {
    $full = __DIR__ . '/' . $dir;
    if (is_dir($full)) {
        $writable = is_writable($full);
        echo $writable 
            ? "<p style='color:green'>✅ $dir is writable</p>" 
            : "<p style='color:red'>❌ $dir is NOT writable (chmod 775 needed)</p>";
    } else {
        echo "<p style='color:orange'>⚠️ $dir does not exist</p>";
    }
}

// 5. Try loading Laravel
echo "<h2>5. Laravel Bootstrap Test</h2>";
try {
    if (!file_exists(__DIR__.'/../vendor/autoload.php')) {
        echo "<p style='color:red'>❌ Cannot test - vendor/autoload.php is missing. Upload the vendor/ folder!</p>";
    } else {
        require __DIR__.'/../vendor/autoload.php';
        echo "<p style='color:green'>✅ Composer autoloader loaded successfully</p>";
        
        try {
            $app = require_once __DIR__.'/../bootstrap/app.php';
            echo "<p style='color:green'>✅ Laravel application bootstrapped successfully</p>";
        } catch (Throwable $e) {
            echo "<p style='color:red'>❌ Laravel bootstrap error: <strong>" . htmlspecialchars($e->getMessage()) . "</strong></p>";
            echo "<pre style='color:red; font-size:12px'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
        }
    }
} catch (Throwable $e) {
    echo "<p style='color:red'>❌ Autoloader error: <strong>" . htmlspecialchars($e->getMessage()) . "</strong></p>";
}

// 6. Database Connection
echo "<h2>6. Database Connection</h2>";
try {
    $host = 'sql102.infinityfree.com';
    $db = 'if0_42520589_german';
    $user = 'if0_42520589';
    $pass = 'germanacademy';
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color:green'>✅ Database connection successful!</p>";
    
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "<p>Tables found: <strong>" . count($tables) . "</strong></p>";
    if (count($tables) > 0) {
        echo "<ul>";
        foreach ($tables as $t) echo "<li>$t</li>";
        echo "</ul>";
    }
} catch (PDOException $e) {
    echo "<p style='color:red'>❌ Database error: <strong>" . htmlspecialchars($e->getMessage()) . "</strong></p>";
}

echo "<hr><p><em>Generated at " . date('Y-m-d H:i:s') . "</em></p>";
