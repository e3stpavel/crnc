<?php

namespace App\Controller;

use App\Model\Currency;
use App\Util\Storage;
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
        Currency::load(new \DateTime('now'));

        Storage::put("hi", ["name" => "bruh", "age" => 12]);
        $json = Storage::get("hi");

        View::show('home', ["data" => $json]);
    }
}
