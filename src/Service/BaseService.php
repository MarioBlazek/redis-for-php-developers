<?php

declare(strict_types=1);

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
     */
    public function __construct(
        RedisConnectionFactory $connectionFactory,
        KeyGenerator $keyGenerator,
        DataMapper $dataMapper
    ) {
        $this->redis = $connectionFactory->getRedis();
        $this->keyGenerator = $keyGenerator;
        $this->dataMapper = $dataMapper;
    }
}
