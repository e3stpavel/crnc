<?php

namespace App\Util;

class View
{
    private string $name;

    private array $vars;

    /**
     * @param string $name
     * @param array $vars
     */
    public function __construct(string $name, array $vars = [])
    {
        $this->name = $name;
        $this->vars = $vars;
    }

    /**
     * @return void
     */
    public function show(): void
    {
        extract($this->vars);

        $name = $this->name;
        require __DIR__ . "\\..\\..\\resources\\views\\$name.php";
    }
}
