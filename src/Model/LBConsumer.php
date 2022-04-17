<?php

namespace App\Model;

class LBConsumer extends Consumer
{
    // Overriding the value of uri
    protected string $uri = 'https://www.lb.lt/en/currency/daylyexport/?csv=1&class=Eu&type=day&date_day=%s';

    /**
     * Implementing get() method
     * Lithuanian Bank API consuming logic
     * @return array ['name' => 'string', 'code' => 'string', 'rate' => floatval(), 'date' => 'Y-m-d']
     */
    public function get(): array
    {
        $result = [];
        $raw = $this->explode();

        for ($i = 0; $i < count($raw) - 1; $i++) {
            if ($i > 0) {
                $temp = explode(';', $raw[$i]);
                array_push($result, [
                    'name' => str_replace('"', '', $temp[0]),
                    'code' => str_replace('"', "", $temp[1]),
                    'rate' => floatval(str_replace(
                        ',',
                        '.',
                        str_replace('"', "", $temp[2])
                    )),
                    'date' => str_replace('"', "", $temp[3]),
                ]);
            }
        }

        return $result;
    }
}
