<?php

declare(strict_types=1);

namespace App\Factory;

use Redis;

class RedisConnectionFactory
{
    /**
     * @var \Redis
     */
    private $redis;

    /**
     * @var array
     */
    private $options;

    public function __construct(array $options = [])
    {
        $this->options = array_merge(
            [
                'host' => '127.0.0.1',
                'port' => 6379,
            ],
            $options
        );
    }

    public function getRedis(): Redis
    {
        if ($this->redis instanceof Redis) {
            return $this->redis;
        }

        $this->redis = new Redis();
        $this->redis->connect($this->options['host'], $this->options['port']);

        return $this->redis;
    }
}
