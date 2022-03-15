<?php

use App\Util\Router;

require __DIR__ . "\\..\\vendor\\autoload.php";
require __DIR__ . "\\..\\routes\\web.php";

$router = new Router($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

try {
    $router->call();
} catch (Exception $e) {
    echo "server error";
}
