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
     * Index page
     * Should load all today's currencies and show to user
     * @return void
     * @throws Exception
     */
    public static function index(): void
    {
        View::show('home', [
            'currencies' => Currency::get(new DateTime('now')),
            'euro' => Currency::base(),
        ]);
//        View::show('test', [
//            'currencies' => $_SESSION['currencies'],
//            'euro' => $_SESSION['euro'],
//            'date' => $_SESSION['latest_date'],
//            'token' => $_SESSION['token']]);
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

    /**
     * Does the actual calculations
     * @throws Exception
     */
    public static function count(): void
    {
        // get the body
        $body = json_decode(file_get_contents('php://input'));

        // compare the session token and the body one
        if ($body->token === $_SESSION['token']) {
            // getting the request values
            $values = $body->values;
            $from = $values->from;
            $to = $values->to;
            $amount = $values->amount;
            $date = $values->date;

            // validate the values
            $errors = [];

            // from currency
            $fromCurrency = Currency::base();
            if ($from !== 'EUR') {
                $fromCurrency = Currency::pick("$date:$from");
            }

            if ($fromCurrency === null) {
                $errors[] = 'Initial currency for specific date has not been found';
            }

            // to currency
            $toCurrency = Currency::base();
            if ($to !== 'EUR') {
                $toCurrency = Currency::pick("$date:$to");
            }

            if ($toCurrency === null) {
                $errors[] = 'To currency for specific date has not been found';
            }

            // amount
            if (strval((float) $amount) !== $amount) {
                $errors[] = 'Provided amount is not a valid float number (use dot .)';
            }
            if (floatval($amount) <= 0) {
                $errors[] = 'Provided amount must be greater than 0';
            }

            // date
            if (DateTime::createFromFormat('Y-m-d', $date) === false) {
                $errors[] = 'Provided date could not be converted to a valid DateTime object';
            }

            // check for errors
            if (count($errors) > 0) {
                // if there are errors send them
                header('Content-type: application/json');
                echo json_encode(array(
                    'value' => 0,
                    'errors' => $errors,
                ));
                return;
            }

            // if no errors were found
            // calculate the result
            // 1 EUR = 1,5 ATH
            // x EUR = 2,3 ATT
            // x = 2,3 / 1,5
            $amount = floatval($amount);

            $fromRate = $fromCurrency->getRate();
            $toRate = $toCurrency->getRate();

            $cross = $toRate / $fromRate;
            $result = $amount * $cross;

            // round it as well
            $result = round($result, 5);

            // just in case
            header('Content-type: application/json');
            if ($result <= 0) {
                echo json_encode(array(
                    'value' => 0,
                    'errors' => 'Something went wrong while calculating the values',
                ));
                return;
            }

            echo json_encode(array(
                'value' => $result,
                'errors' => [],
            ));

            return;
        }

        // else throw a bad request
        header('HTTP/1.1 400 BAD REQUEST (Your session has expired)');
    }

    /**
     * Return the rate for specific Currency within specific date
     * @throws Exception
     */
    public static function rate(): void
    {
        // get the body
        $body = json_decode(file_get_contents('php://input'));

        // compare the session token and the body one
        if ($body->token === $_SESSION['token']) {
            // getting the request values
            $values = $body->values;
            $from = $values->currency;
            $date = $values->date;

            // validate the values
            $currency = Currency::base();
            if ($from !== 'EUR') {
                $currency = Currency::pick("$date:$from");
            }

            if ($currency === null) {
                header('Content-type: application/json');
                echo json_encode(array(
                    'value' => 0,
                    'errors' => [
                        'Currency for specific date has not been found',
                    ],
                ));
                return;
            }

            // get the rate
            $rate = $currency->getRate();

            header('Content-type: application/json');
            echo json_encode(array(
                'value' => $rate,
                'errors' => [],
            ));

            return;
        }

        // else throw a bad request
        header('HTTP/1.1 400 BAD REQUEST (Your session has expired)');
    }
}
