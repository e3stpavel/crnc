<?php

namespace App\Util;

use Redis;
use Redislabs\Module\RedisJson\RedisJson;
use Spatie\Async\Pool;

class Storage
{
    private RedisJson $redisJson;

    /**
     * @param string $host Optional, default value is 127.0.0.1
     * @param int $port Optional, default value is 6379
     * @return RedisJson
     */
    public static function getRedisJson(string $host = "", int $port = 0): RedisJson
    {
        $storage = new Storage();
        if ($host !== "" || $port !== 0) {
            $storage = new Storage($host, $port);
        }

        return $storage->redisJson;
    }

    /**
     * @param string $host
     * @param int $port
     */
    public function __construct(string $host = "127.0.0.1", int $port = 6379)
    {
        // Connect to Redis storage
        $redisClient = new Redis();
        $redisClient->connect($host, $port);
        // $redisClient->auth($password);

        $this->redisJson = RedisJson::createWithPhpRedis($redisClient);
    }

    /**
     * @param string $key
     * @return array
     */
    public static function get(string $key): array
    {
        $redisJson = self::getRedisJson();

        return $redisJson->get($key, '.');
    }

    /*public function getAll(array $keys): array
    {
    }

    public function getValue(string $key, string $field): mixed
    {
    }*/

    /**
     * @param string $key
     * @param array $values
     */
    public static function put(string $key, array $values):void
    {
        $redisJson = self::getRedisJson();

        $redisJson->set($key, '.', $values);
    }

    /*
    public function set(string $key, string $field, mixed $value): void
    {
    }*/

    public static function flush(): void
    {
        $redisJson = self::getRedisJson();

        $redisJson->raw("FLUSHDB");
    }
}
