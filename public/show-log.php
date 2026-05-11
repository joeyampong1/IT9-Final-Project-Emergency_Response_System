<?php
$logFile = __DIR__ . '/../storage/logs/laravel.log';
if (file_exists($logFile)) {
    echo '<pre>' . htmlspecialchars(file_get_contents($logFile)) . '</pre>';
} else {
    echo 'Log file not found.';
}
?>
