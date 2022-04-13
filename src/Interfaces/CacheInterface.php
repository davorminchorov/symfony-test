<?php

namespace App\Interfaces;

interface CacheInterface
{
    /**
     * Gets a value from the cache storage.
     */
    public function get(string $key): string;

    /**
     * Sets a value into the cache storage.
     */
    public function set(string $key, string $value): string;

    /**
     * Push a value into the cache storage.
     */
    public function push(string $key, array $values): int;

    /**
     * Removes specific value(s) from the cache storage.
     */
    public function pop(string $key, int $numberOfItems = 1): array;
}
