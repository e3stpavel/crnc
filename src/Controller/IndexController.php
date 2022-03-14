<?php

namespace App\Controller;

use App\View\View;

class IndexController
{
    public function index(): void
    {
        $view = new View('home');
        $view->show();
    }
}
