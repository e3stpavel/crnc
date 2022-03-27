<?php

namespace App\Model;

use App\Util\Storage;
use DateTime;
use DateTimeZone;
use Exception;

class Currency
{
    private string $code;

    private string $name;

    private float $rate;

    private DateTime $date;

    private string $flag;

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

    /**
     * Manages time and returns string with date format Y-m-d
     * @param DateTime $date
     * @return string
     * @throws Exception
     */
    public static function manage(DateTime $date): string
    {
        // check if now and move back in time
        $date = $date->setTimezone(new DateTimeZone('Europe/Helsinki'));
        $requested = $date->format('Y-m-d');
        $now = new DateTime('now', new DateTimeZone('Europe/Helsinki'));
        $current = $now->format('Y-m-d');

        // if today or requested date is in future
        if ($current === $requested || $now < $date) {
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

        return $requested;
    }

    /**
     * Loads the collection of currencies for specific date
     * @param DateTime $date
     * @throws Exception
     */
    public static function load(DateTime $date): void
    {
        $date = self::manage($date);

        // Eesti pank link
        $etBankApi = "https://haldus.eestipank.ee/en/export/currency_rates?imported=$date&type=csv";

        // Lithuanian bank link
        $ltBankApi = "https://www.lb.lt/en/currency/daylyexport/?csv=1&class=Eu&type=day&date_day=$date";

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

            // creating object
            self::create($currency);
        }
    }

    /**
     * Creating the currency object instance in Storage from associative array
     * @param array $values
     */
    public static function create(array $values): void
    {
        // create a currency instance and place to the Storage
        // use key like date:code, example 25-03-2022:AUD
        Storage::put(
            $values['date']->format('Y-m-d') . ':' . $values['code'],
            [
                'name' => $values['name'],
                'rate' => $values['rate'],
                'flag' => $values['flag']
            ]
        );
    }

    /**
     * Assign raw array from Storage::get() to Currency interface
     * @param array $values
     * @return Currency
     * @throws Exception
     */
    public static function assign(array $values): Currency
    {
        // get the key
        $key = array_keys($values)[0];

        // get the other values
        $values = $values[$key];
        $key = explode(":", $key);

        // get the date and the code
        $date = $key[0];
        $code = $key[1];

        return new Currency(
            $code,
            $values['name'],
            $values['rate'],
            new DateTime($date, new DateTimeZone('Europe/Helsinki')),
            $values['flag']
        );
    }

    /**
     * Gets all Currencies by specific date
     * @param DateTime $date
     * @return array
     * @throws Exception
     */
    public static function get(DateTime $date): array
    {
        $date = self::manage($date);

        $currencies = Storage::getAll($date);
        $result = [];

        // check if exists in the Storage
        if ($currencies === []) {
            // if not load the list for specific date
            $d = new DateTime($date, new DateTimeZone('Europe/Helsinki'));
            self::load($d);

            // get list of currencies from Storage
            $currencies = Storage::getAll($date);
        }

        // assign all currencies to the Currency interface
        foreach ($currencies as $currency) {
            array_push($result, self::assign($currency));
        }

        // sort in ascending order by value
        asort($result);

        return $result;
    }

    /**
     * Picks the currency by its key (looking for in the Storage, if not found doing load)
     * @param string $key
     * @return Currency
     * @throws Exception
     */
    public static function pick(string $key): Currency
    {
        $currency = Storage::get($key);

        // check if exists in the Storage
        if ($currency === null) {
            // if not load the list for specific date
            $date = explode(":", $key)[0];
            $date = new DateTime($date, new DateTimeZone('Europe/Helsinki'));

            self::load($date);

            // get from the Storage
            $currency = Storage::get($key);
        }

        // assign to the Currency interface
        return self::assign($currency);
    }

    // Getters and Setters //
    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     */
    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getFlag(): string
    {
        return $this->flag;
    }

    /**
     * @param string $flag
     */
    public function setFlag(string $flag): void
    {
        $this->flag = $flag;
    }
}
