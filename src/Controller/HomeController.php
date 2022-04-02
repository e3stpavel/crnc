<?php

namespace App\Controller;

use App\Model\Currency;
use App\Util\Storage;
use App\Util\View;
use DateTime;
use eftec\bladeone\BladeOne;
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
        $_SESSION['currencies'] = Currency::get(new DateTime('now'));
        $_SESSION['euro'] = Currency::base();

        // View::show('home', ['currencies' => $_SESSION['currencies'], 'euro' => $_SESSION['euro']]);
        View::show('test', [
            'currencies' => $_SESSION['currencies'],
            'euro' => $_SESSION['euro'],
            'date' => $_SESSION['latest_date'],
            'token' => $_SESSION['token']]);
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
            if (!Currency::validate($from, $date) && $from !== 'EUR') {
                $errors[] = 'Provided from currency is not valid!';
            }

            // to currency
            if (!Currency::validate($to, $date) && $to !== 'EUR') {
                $errors[] = 'Provided to currency is not valid!';
            }

            // amount
            if (strval((float) $amount) !== $amount) {
                $errors[] = 'Provided amount is not a valid float number';
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
            $fromCurrency = Currency::base();
            if ($from !== 'EUR') {
                $fromCurrency = Currency::pick("$date:$from");
            }

            $toCurrency = Currency::base();
            if ($to !== 'EUR') {
                $toCurrency = Currency::pick("$date:$to");
            }

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
            if (!Currency::validate($from, $date) && $from !== 'EUR') {
                header('Content-type: application/json');
                echo json_encode(array(
                    'value' => 0,
                    'errors' => [
                        'Provided currency is not valid!'
                    ],
                ));
                return;
            }

            // get the rate
            $currency = Currency::base();
            if ($from !== 'EUR') {
                $currency = Currency::pick("$date:$from");
            }
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

//    public static function validateCurrency(string $currency, DateTime $date): false | Currency
//    {
//        // currency must be an existing currency
//        $result = Currency::pick($date->format('Y-m-d') . ":" . $currency);
//        if ($currency == 'EUR') {
//            $result = Currency::base();
//        }
//
//        if ($result === null) {
//            return false;
//        }
//
//        return $result;
//    }
//
//    public static function validate(): void
//    {
//        var_dump($_POST);
//        $errors = [];
//
//        // amount must be float, no letters
//        $amount = $_POST['amount'];
//        if (!is_numeric($amount)) {
//            array_push($errors, "Amount must be a valid number, containing no letters or special symbols");
//        }
//        $amount = floatval($amount);
//
//        // date must convert to DateTime and no future
//        $date = $_POST['date'];
//        $date = DateTime::createFromFormat('Y-m-d', $date);
//        if ($date === false) {
//            array_push($errors, "Date must be a valid date, chosen using date picker");
//        }
//        if ($date > new DateTime('now')) {
//            array_push($errors, "Date must be in past or present, not in future");
//        }
//
//        // validate currencies
//        $from = $_POST['from'];
//        $from = self::validateCurrency($from, $date);
//        if ($from === false) {
//            array_push($errors, "Seems like you are trying to access not existing currency");
//        }
//
//        $to = $_POST['to'];
//        $to = self::validateCurrency($to, $date);
//        if ($to === false) {
//            array_push($errors, "Seems like you are trying to access not existing currency");
//        }
//
//        // TODO: check token
//
//        $_POST = array();
//        // if errors return them
//        if (count($errors) > 0) {
//            $_POST['errors'] = $errors;
//        }
//
//        echo 'success';
//        die();
//    }
}
