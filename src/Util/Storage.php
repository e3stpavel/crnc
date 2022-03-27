<?php

namespace App\Util;

use Exception;
use Redis;
use Redislabs\Module\RedisJson\RedisJson;

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
     * @return array|null
     */
    public static function get(string $key): array | null
    {
        $redisJson = self::getRedisJson();

        try {
            $result = $redisJson->mget($key, '.');
        } catch (Exception $exception) {
            // TODO: write to logs
            $result = null;
        }

        return $result;
    }

    /**
     * @param string $pattern
     * @return array
     */
    public static function getAll(string $pattern = ""): array
    {
        $redisJson = self::getRedisJson();
        $redisClient = $redisJson->getClient();

        // stupid workaround because it's not working with variables
        $keys = $redisClient->keys("*");
        $filtered = [];
        $pattern = iconv(
            mb_detect_encoding($pattern, mb_detect_order(), true),
            "UTF-8",
            $pattern
        );

        foreach ($keys as $key) {
            // different encodings, fix that
            $key = iconv(
                mb_detect_encoding((string) $key, mb_detect_order(), true),
                "UTF-8",
                (string) $key
            );

            if (str_contains($key, $pattern) || $pattern === "") {
                array_push($filtered, $key);
            }
        }

        try {
            $result = [];
            foreach ($filtered as $key) {
                $result[] = $redisJson->mget($key, ".");
            }
        } catch (Exception $exception) {
            // TODO: write to logs
            $result = [];
        }

        return $result;
    }

    /**
     * @param string $key
     * @param array $values
     */
    public static function put(string $key, array $values): void
    {
        $redisJson = self::getRedisJson();

        $redisJson->set($key, '.', $values);
    }

    /**
     * Development purposes only
     */
    public static function flush(): void
    {
        $redisJson = self::getRedisJson();

        $redisJson->raw("FLUSHDB");
    }
}
