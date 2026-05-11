<?php


echo "INDEX.PHP IS REACHED. Time: " . date('Y-m-d H:i:s');

// Force all errors to be displayed
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Custom error handler to catch everything
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    echo "<b>Error:</b> [$errno] $errstr<br>";
    echo "File: $errfile, Line: $errline<br>";
    return true;
});

register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        echo "<b>Fatal error:</b> " . $error['message'] . "<br>";
        echo "File: " . $error['file'] . ", Line: " . $error['line'];
    }
});

try {
    define('LARAVEL_START', microtime(true));
    
    // Maintenance mode check
    if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
        require $maintenance;
    }
    
    // Autoloader
    require __DIR__.'/../vendor/autoload.php';
    
    // Bootstrap app
    $app = require_once __DIR__.'/../bootstrap/app.php';
    
    // Handle request
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );
    $response->send();
    $kernel->terminate($request, $response);
    
} catch (Throwable $e) {
    echo "<h1>Laravel Exception</h1>";
    echo "<b>Message:</b> " . $e->getMessage() . "<br>";
    echo "<b>File:</b> " . $e->getFile() . "<br>";
    echo "<b>Line:</b> " . $e->getLine() . "<br>";
    echo "<b>Stack trace:</b><pre>" . $e->getTraceAsString() . "</pre>";
}