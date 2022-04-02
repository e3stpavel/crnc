<?php

namespace App\Util;

use eftec\bladeone\BladeOne;
use Exception;

class View
{
    private static string $views = __DIR__ . "\\..\\..\\resources\\views\\";

    private static string $cache = __DIR__ . "\\..\\..\\compiled\\cache\\";

    /**
     * @param string $name View name, should be placed under resource/views/
     * @param array $vars Must be an associative array with keys
     * @param string $varsName If array is sequential, then provide a name which will be available in blade file
     * @throws Exception
     */
    public static function show(string $name, array $vars = [], string $varsName = "vars"): BladeOne
    {
        $blade = new BladeOne(self::$views, self::$cache, BladeOne::MODE_DEBUG);

        $blade->setView($name);

        // if vars array not empty
        if (count($vars) > 0) {
            // if vars array os not associative then make it associative
            if (!self::isVarsAssoc($vars)) {
                $vars = array($varsName => $vars);
            }

            $blade->share($vars);
        }

        echo $blade->run();
        return $blade;
    }

    private static function isVarsAssoc(array $vars): bool
    {
        if (array() === $vars) {
            return false;
        }

        return array_keys($vars) !== range(0, count($vars) - 1);
    }
}
