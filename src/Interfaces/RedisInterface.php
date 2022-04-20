<?php

namespace App\Interfaces;

interface RedisInterface
{
    /**
     * Gets the value(s) for a specific key from Redis.
     *
     * @param  string  $key
     *
     * @return string|null
     */
    public function get(string $key): ?string;

    /**
     * Sets a single value into Redis.
     *
     * @param  string  $key
     * @param  string  $value
     * 
     * @return string
     */
    public function set(string $key, string $value): string;

    /**
     * Push multiple values into Redis.
     * 
     * @param  string  $key
     * @param  array  $values
     * 
     * @return int
     */
    public function push(string $key, array $values): int;

    /**
     * Removes a number of values from Redis.
     *
     * @param  string  $key
     * @param  int  $numberOfItems
     *
     * @return string|array|null
     */
    public function pop(string $key, int $numberOfItems): null|string|array;
}
