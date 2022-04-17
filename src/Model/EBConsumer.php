<?php

namespace App\Model;

// Estonian Bank Consumer SubClass
class EBConsumer extends Consumer
{
    // Overriding the value of uri
    protected string $uri = 'https://haldus.eestipank.ee/en/export/currency_rates?imported=%s&type=csv';

    /**
     * Implementing get() method
     * Estonian Bank API consuming logic
     * @return array ['CODE' => floatval()]
     */
    public function get(): array
    {
        $result = [];
        $raw = $this->explode();

        for ($i = 0; $i < count($raw) - 1; $i++) {
            if ($i > 2) {
                $temp = explode(',', $raw[$i]);
                $result[$temp[0]] = floatval($temp[1]);
            }
        }

        return $result;
    }
}
