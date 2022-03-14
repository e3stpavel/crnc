<?php

namespace App\Controller;

use App\View\View;

class HomeController
{
    public function index(): void
    {
        $view = new View('home');
        $view->show();
    }
}
