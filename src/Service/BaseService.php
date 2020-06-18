<?php

namespace App\Service;

use App\Factory\RedisConnectionFactory;
use App\Util\DataMapper;
use App\Util\KeyGenerator;

abstract class BaseService
{
    /**
     * @var \Redis
     */
    protected $redis;

    /**
     * @var \App\Util\KeyGenerator
     */
    protected $keyGenerator;

    /**
     * @var \App\Util\DataMapper
     */
    protected $dataMapper;

    /**
     * BaseService constructor.
     *
     * @param \App\Factory\RedisConnectionFactory $connectionFactory
     * @param \App\Util\KeyGenerator $keyGenerator
     * @param \App\Util\DataMapper $dataMapper
     */
    public function __construct(
        RedisConnectionFactory $connectionFactory,
        KeyGenerator $keyGenerator,
        DataMapper $dataMapper
    )
    {
        $this->redis = $connectionFactory->getRedis();
        $this->keyGenerator = $keyGenerator;
        $this->dataMapper = $dataMapper;
    }
}
