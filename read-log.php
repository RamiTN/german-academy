<?php
// Simple script to read the Laravel log file on InfinityFree

$logFile = __DIR__.'/toinfinity/storage/logs/laravel.log';

echo "<h1>Laravel Error Log</h1>";

if (!file_exists($logFile)) {
    echo "<p style='color:red'>Log file not found at: " . htmlspecialchars($logFile) . "</p>";
    exit;
}

if (!is_readable($logFile)) {
    echo "<p style='color:red'>Log file exists but is not readable (check permissions).</p>";
    exit;
}

$contents = file_get_contents($logFile);

if (trim($contents) === '') {
    echo "<p>Log file is empty.</p>";
} else {
    // Show only the last 100 lines for readability
    $lines = explode("\n", $contents);
    $lastLines = array_slice($lines, -100);
    echo "<pre style='background:#111; color:#0f0; padding:10px; overflow-x:scroll;'>" . htmlspecialchars(implode("\n", $lastLines)) . "</pre>";
}
