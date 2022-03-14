<?php

namespace App\Model;

use DateTime;

class Currency
{
    // default values are for EUR
    // working like an id field
    public string $code;

    public string $name;

    public float $rate;

    public DateTime $date;

    /**
     * @param string $code
     * @param string $name
     * @param float $rate
     * @param DateTime $date
     */
    public function __construct(
        string   $code,
        string   $name,
        float    $rate,
        DateTime $date
    ) {
        $this->code = $code;
        $this->name = $name;
        $this->rate = $rate;
        $this->date = $date;
    }

    /*public function exchangeToEur(): Currency
    {
        // $now = new DateTime('now');
        $eur = new Currency($now);
    }*/
}
