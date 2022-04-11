<?php

namespace App\Util;

use JetBrains\PhpStorm\ArrayShape;

class Manifest
{
    /**
     * Reading the Manifest with Record<name, chunk> structure file and returning static assets for production use
     * @param string $name of the record
     * @param string $path path to the manifest.json file, default is 'dist'
     */
    public static function read(string $name, string $path = 'dist'): array
    {
        // get the path to the manifest
        $src = __DIR__ . "\\..\\..\\$path\\manifest.json";

        // get the manifest data
        $json = file_get_contents($src);
        $manifest = json_decode(json_encode(json_decode($json)), true);

        // get the main.ts record
        $keys = array_keys($manifest);

        return $manifest[$keys[0]];
    }

    /**
     * Just for development use
     * @return array
     */
    #[ArrayShape(['css' => "string", 'file' => "string"])] public static function init(): array
    {
        return array('css' => '', 'file' => '');
    }
}
