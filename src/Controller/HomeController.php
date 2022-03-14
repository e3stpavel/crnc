<?php

namespace App\Controller;

use App\Util\View;

class HomeController
{
    /**
     * @return void
     */
    public function index(): void
    {
        $view = new View('home');
        $view->show();
    }
}
