<?php

use App\Util\Router;

require __DIR__ . "\\..\\vendor\\autoload.php";
require __DIR__ . "\\..\\routes\\web.php";

$router = new Router($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

// starting the session and putting unique token to validate
session_start();
if (!isset($_SESSION['token']) || $_SESSION['token'] === null) {
    $_SESSION['token'] = uniqid('e3', true);
}

if (!isset($_SESSION['latest_date']) || $_SESSION['latest_date'] === null) {
    $_SESSION['latest_date'] = date('Y-m-d', strtotime('today'));
}

try {
    $router->call();
} catch (Exception $e) {
    echo "Server error: " . PHP_EOL . $e->getMessage() . PHP_EOL . $e->getTraceAsString();
}
