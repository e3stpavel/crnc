<?php

use App\Util\Router;

require __DIR__ . "\\..\\vendor\\autoload.php";
require __DIR__ . "\\..\\routes\\web.php";

$router = new Router($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

// starting the session and putting unique token to validate
session_start();
if ($_SESSION['token'] === null) {
    $_SESSION['token'] = uniqid('e3', true);
}

try {
    $router->call();
} catch (Exception $e) {
    echo "Server error: " . PHP_EOL . $e->getMessage() . PHP_EOL . $e->getTraceAsString();
}
