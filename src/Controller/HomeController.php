<?php

namespace App\Controller;

use App\Model\Currency;
use App\Util\View;
use DateTime;
use Exception;

class HomeController
{
    /**
     * Index page (loads all today's currencies if not exists in the Storage)
     * @return void
     * @throws Exception
     */
    public static function index(): void
    {
        $currencies = Currency::get(new DateTime('now'));

        View::show('home', ['currencies' => $currencies]);
    }
}
