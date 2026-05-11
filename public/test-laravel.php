<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    require __DIR__ . '/../vendor/autoload.php';
    echo "Autoload loaded.<br>";
    
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    echo "App bootstrap loaded.<br>";
    
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    echo "Kernel created.<br>";
    
    echo "Laravel seems to load correctly.";
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine();
}