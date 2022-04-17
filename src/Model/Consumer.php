<?php

namespace App\Model;

use JetBrains\PhpStorm\Pure;
use LogicException;

abstract class Consumer
{
    /**
     * @var string Pass the date while creating new object to load the rates
     */
    protected string $date;

    /**
     * @var string Provide Uri as a sprintf format string. Override the value of a property in your subclass.
     */
    protected string $uri;

    final public function __construct(string $date)
    {
        // check for uri property
        if (!isset($this->uri)) {
            throw new LogicException(get_class($this) . ' must have a uri property');
        }

        $this->date = $date;
    }

    /**
     * @return string Formatting the uri (adding the date to sprintf format string)
     */
    protected function format(): string
    {
        return sprintf($this->uri, $this->date);
    }

    /**
     * @return string Getting the file from an uri and returning a raw string
     */
    protected function raw(): string
    {
        return file_get_contents($this->format());
    }

    /**
     * @return array Utility method to make working with CSV files a bit easier
     */
    protected function explode(): array
    {
        return explode("\n", $this->raw());
    }

    abstract public function get(): array;

    //// Getters ////
    public function getDate(): string
    {
        return $this->date;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    #[Pure] public function getFormatUri(): string
    {
        return $this->format();
    }
}
