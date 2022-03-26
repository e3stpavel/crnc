<?php

namespace App\Model;

use App\Util\Storage;
use DateTime;
use DateTimeZone;
use Exception;

class Currency
{
    public string $code;

    public string $name;

    public float $rate;

    public DateTime $date;

    public string $flag;

    /**
     * @param string $code
     * @param string $name
     * @param float $rate
     * @param DateTime $date
     * @param string $flag
     */
    public function __construct(
        string   $code,
        string   $name,
        float    $rate,
        DateTime $date,
        string $flag
    ) {
        $this->code = $code;
        $this->name = $name;
        $this->rate = $rate;
        $this->date = $date;
        $this->flag = $flag;
    }


    public static function create(array $values): void
    {
        // create a currency instance and place to the Storage
        // TODO: assign raw array to an object and put it into the storage
        // use key like date:code, example 25-03-2022:AUD
    }

    // TODO: get all currencies or by key
    // TODO: check if exist in Storage if not load from api
    /*
    public static function get(string $key): Currency
    {
        return new Currency();
    }*/

    /**
     * @throws Exception
     */
    public static function load(DateTime $date): void
    {
        // check if now and move back in time
        $requested = $date->setTimezone(new DateTimeZone('Europe/Helsinki'))->format('Y-m-d');
        $now = new DateTime('now', new DateTimeZone('Europe/Helsinki'));
        $current = $now->format('Y-m-d');

        if ($current === $requested) {
            // goto previous day
            $requested = date('Y-m-d', strtotime("-1 days"));

            // if time is not 13:00 yet
            if (intval($now->format('G')) <= 13) {
                // goto two days before
                $requested = date('Y-m-d', strtotime("-2 days"));
            }

            // if weekend goto Friday
            if ($now->format('N') >= 6) {
                $requested = date('Y-m-d', strtotime("friday this week"));
            }
        }

        // Eesti pank link
        $etBankApi = "https://haldus.eestipank.ee/en/export/currency_rates?imported=$requested&type=csv";

        // Lithuanian bank link
        $ltBankApi = "https://www.lb.lt/en/currency/daylyexport/?csv=1&class=Eu&type=day&date_day=$requested";

        // process rates from Eesti pank
        $etRatesRaw = file_get_contents($etBankApi);
        $etRatesRaw = explode("\n", $etRatesRaw);
        $etRates = [];
        for ($i = 0; $i < count($etRatesRaw) - 1; $i++) {
            if ($i > 2) {
                $temp = explode(",", $etRatesRaw[$i]);
                $etRates[$temp[0]] = floatval($temp[1]);
            }
        }

        // process rates from Lithuanian bank
        $ltRatesRaw = file_get_contents($ltBankApi);
        $ltRatesRaw = explode("\n", $ltRatesRaw);
        $ltRates = [];
        for ($i = 0; $i < count($ltRatesRaw) - 1; $i++) {
            if ($i > 0) {
                $temp = explode(";", $ltRatesRaw[$i]);
                array_push($ltRates, [
                    'name' => str_replace('"', "", $temp[0]),
                    'code' => str_replace('"', "", $temp[1]),
                    'rate' => str_replace('"', "", $temp[2]),
                    'date' => str_replace('"', "", $temp[3]),
                ]);
            }
        }

        /*var_dump($ltRates);
        var_dump($etRates);*/

        // form the objects from this api data
        // assume that arrays has the same length cuz they use same data provider
        for ($i = 0; $i < count($etRates); $i++) {
            // form an object containing all the Currency model fields
            $currency = [
                'code' => $ltRates[$i]['code'],
                'name' => $ltRates[$i]['name'],
                'rate' => $etRates[$ltRates[$i]['code']],
                'date' => new DateTime($ltRates[$i]['date'], new DateTimeZone('Europe/Helsinki')),
                'flag' => strtolower(substr($ltRates[$i]['code'], 0, -1))
            ];

            var_dump($currency);
            // creating object
            self::create($currency);
        }

        die();
    }

    /*public function exchangeToEur(): Currency
    {
        // $now = new DateTime('now');
        $eur = new Currency($now);
    }*/
}
