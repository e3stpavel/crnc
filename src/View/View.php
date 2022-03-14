<?php

namespace App\View;

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

    public function show(): void
    {
        extract($this->vars);

        $name = $this->name;
        require __DIR__ . "\\$name.php";
    }
}
