<?php

namespace App\Util;

use Exception;
use Redis;
use Redislabs\Module\RedisJson\RedisJson;

class Storage
{
    private RedisJson $redisJson;

    /**
     * @return RedisJson
     */
    public static function getRedisJson(): RedisJson
    {
        $storage = new Storage();

        return $storage->redisJson;
    }

    public function __construct()
    {
        // Get host and port
        $host = $_ENV['REDIS_HOST'];
        $port = $_ENV['REDIS_PORT'];

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
        $pattern = utf8_encode($pattern);

        $keys = $redisClient->keys("*$pattern*");

        try {
            $result = [];

            foreach ($keys as $key) {
                $result[] = $redisJson->mget($key, '.');
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
