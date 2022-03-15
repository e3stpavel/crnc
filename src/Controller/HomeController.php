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
    public static function index(): void
    {
        // $name = array("who" => "my", "what" => "knees");
        $name = array("my", "god");

        View::show('home', $name, "name");
    }
}
