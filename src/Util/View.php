<?php

namespace App\Util;

use eftec\bladeone\BladeOne;
use Exception;

class View
{
    private string $name;

    private array $vars;

    protected string $views;

    protected string $cache;

    private object $blade;

    /**
     * @param string $name
     * @param array $vars
     */
    public function __construct(string $name, array $vars = [])
    {
        // TODO: fix the path
        $views = __DIR__ . "\\..\\..\\resources\\views\\$name.php";
        $cache = __DIR__ . "..\\..\\..\\compiled\\cache\\";
        $this->name = $name;
        $this->vars = $vars;
        $this->views = $views;
        $this->cache = $cache;
        $this->blade = new BladeOne($this->views, $this->cache, BladeOne::MODE_DEBUG);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function show(): void
    {
        // extract($this->vars);

        /*$name = $this->name;
        require __DIR__ . "\\..\\..\\resources\\views\\$name.php";*/

        echo $this->blade->setView($this->name)
            ->share($this->vars)
            ->run();
    }
}
