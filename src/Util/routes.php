<?php

use App\Controller\IndexController;
use App\Util\Router;

// declare the routes here
Router::get('/', [IndexController::class, 'index']);
