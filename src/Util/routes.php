<?php

use App\Controller\HomeController;
use App\Util\Router;

// declare the routes here
Router::get('/', [HomeController::class, 'index']);
