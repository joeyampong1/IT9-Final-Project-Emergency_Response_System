<?php
// Display errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Try to run a simple artisan command via shell
$output = shell_exec('cd /var/www/html && php artisan --version 2>&1');
echo "<pre>Artisan version: " . htmlspecialchars($output) . "</pre>";

// Check if error log exists
$errorLog = '/var/log/apache2/error.log';
if (file_exists($errorLog)) {
    echo "<h3>Last 50 lines of Apache error log:</h3>";
    $lines = file($errorLog);
    $last = array_slice($lines, -50);
    echo "<pre>" . htmlspecialchars(implode('', $last)) . "</pre>";
} else {
    echo "Apache error log not found at $errorLog";
}

// Also check Laravel's log
$laravelLog = __DIR__ . '/../storage/logs/laravel.log';
if (file_exists($laravelLog)) {
    echo "<h3>Laravel log:</h3>";
    echo "<pre>" . htmlspecialchars(file_get_contents($laravelLog)) . "</pre>";
} else {
    echo "Laravel log not found.";
}
?>