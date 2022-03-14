<?php

namespace App\Controller;

use App\Util\View;
use Exception;

class HomeController
{
    /**
     * @return void
     * @throws Exception
     */
    public function index(): void
    {
        $name = "my";
        $view = new View('home', array($name));
        $view->show();
    }
}
