<?php

use App\Controller\HomeController;
use App\Util\Router;

// declare the routes here
// GET routes
Router::get('/', [HomeController::class, 'index']);

// POST routes
Router::post('/', [HomeController::class, 'validate']);
