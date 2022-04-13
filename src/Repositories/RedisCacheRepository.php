<?php

namespace App\Repositories;

use App\Interfaces\CacheInterface;
use App\Interfaces\RedisInterface;

class RedisCacheRepository implements CacheInterface
{
    /**
     * @param RedisInterface $redis
     */
    public function __construct(private readonly RedisInterface $redis)
    {
    }

    /**
     * Gets a specific value from the cache storage.
     */
    public function get(string $key): string
    {
        return $this->redis->get($key);
    }

    /**
     * Sets a specific value into the cache storage.
     */
    public function set(string $key, string $value): string
    {
        return $this->redis->set($key, $value);
    }

    /**
     * Push multiple values for a specific key into the cache storage.
     */
    public function push(string $key, array $values): int
    {
        return $this->redis->push($key, $values);
    }

    /**
     * Removes specific value(s) from the cache storage.
     */
    public function pop(string $key, int $numberOfItems = 1): array
    {
        return $this->redis->pop($key, $numberOfItems);
    }
}
