<?php

use App\Controller\HomeController;
use App\Util\Router;

// declare the routes here
// GET routes
Router::get('/', [HomeController::class, 'index']);

// POST routes
Router::post('/', [HomeController::class, 'count']);
Router::post('/rate', [HomeController::class, 'rate']);

// development use only routes
// TODO: Remove dev routes
Router::get('/flush', [HomeController::class, 'flush']);
