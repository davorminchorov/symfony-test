<?php

namespace App\Services;

use App\Enums\RedisCommand;
use App\Interfaces\RedisInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class Redis implements RedisInterface
{
    /**
     * @var
     */
    private $redis;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerBagInterface $parameters)
    {
        $this->redis = phpiredis_connect($parameters->get('redis.host'), $parameters->get('redis.port'));
    }

    /**
     * Gets the value(s) for a specific key from Redis.
     */
    public function get(string $key): string
    {
        return phpiredis_command_bs($this->redis, [
            RedisCommand::GET->value, $key,
        ]);
    }

    /**
     * Sets a single value into Redis.
     */
    public function set(string $key, string $value): string
    {
        return phpiredis_command_bs($this->redis, [
            RedisCommand::SET->value, $key, $value,
        ]);
    }

    /**
     * Push multiple values into Redis.
     */
    public function push(string $key, array $values): int
    {
        return phpiredis_command_bs($this->redis, [
            RedisCommand::RPUSH->value, $key, implode(', ', $values),
        ]);
    }

    /**
     * Removes a number of values from Redis.
     */
    public function pop(string $key, int $numberOfItems = 1): array
    {
        return phpiredis_command_bs($this->redis, [
            RedisCommand::LPOP->value, $key, $numberOfItems,
        ]);
    }
}
