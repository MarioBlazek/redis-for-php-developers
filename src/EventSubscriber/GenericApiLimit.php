<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Service\ApiRateLimiterService;
use Symfony\Component\Security\Core\Security;

abstract class GenericApiLimit
{
    protected const EVERY_MINUTE = 1;

    protected const MAX_HITS_PER_MINUTE = 5;

    protected const SECURE_ROUTE_PREFIX = 'mb_secure';

    /**
     * @var \App\Service\ApiRateLimiterService
     */
    protected $limiterService;

    /**
     * @var \Symfony\Component\Security\Core\Security
     */
    protected $security;

    public function __construct(ApiRateLimiterService $limiterService, Security $security)
    {
        $this->limiterService = $limiterService;
        $this->security = $security;
    }
}
