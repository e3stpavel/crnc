<?php

require __DIR__ . "\\..\\vendor\\autoload.php";
require __DIR__ . "\\..\\routes\\web.php";

$router = new \App\Util\Router($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
$router->call();
