<?php

namespace App\Controller;

use App\Model\Currency;
use App\Util\Storage;
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
        Currency::load(new DateTime('2023-04-05'));
        die();

        /*$currencies = Currency::get(new DateTime('now'));
        $euro = Currency::base();

        View::show('home', ['currencies' => $currencies, 'euro' => $euro]);*/
    }

    /**
     * Clearing up all data in the Storage
     * TODO: Remove this method
     */
    public static function flush(): void
    {
        Storage::flush();
        echo 'DB is clean';
    }

    public static function validateCurrency(string $currency, DateTime $date): false | Currency
    {
        // currency must be an existing currency
        $result = Currency::pick($date->format('Y-m-d') . ":" . $currency);
        if ($currency == 'EUR') {
            $result = Currency::base();
        }

        if ($result === null) {
            return false;
        }

        return $result;
    }

    public static function validate(): void
    {
        var_dump($_POST);
        $errors = [];

        // amount must be float, no letters
        $amount = $_POST['amount'];
        if (!is_numeric($amount)) {
            array_push($errors, "Amount must be a valid number, containing no letters or special symbols");
        }
        $amount = floatval($amount);

        // date must convert to DateTime and no future
        $date = $_POST['date'];
        $date = DateTime::createFromFormat('Y-m-d', $date);
        if ($date === false) {
            array_push($errors, "Date must be a valid date, chosen using date picker");
        }
        if ($date > new DateTime('now')) {
            array_push($errors, "Date must be in past or present, not in future");
        }

        // validate currencies
        $from = $_POST['from'];
        $from = self::validateCurrency($from, $date);
        if ($from === false) {
            array_push($errors, "Seems like you are trying to access not existing currency");
        }

        $to = $_POST['to'];
        $to = self::validateCurrency($to, $date);
        if ($to === false) {
            array_push($errors, "Seems like you are trying to access not existing currency");
        }

        // TODO: check token

        $_POST = array();
        // if errors return them
        if (count($errors) > 0) {
            $_POST['errors'] = $errors;
        }

        echo 'success';
        die();
    }
}
