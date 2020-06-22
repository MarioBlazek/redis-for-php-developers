<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\ApiLimitReachedException;
use App\Value\Customer;

class ApiRateLimiterService extends BaseService
{
    public function getHits(Customer $customer, int $interval, int $maxHits): int
    {
        $key = $this->keyGenerator->getRateLimiterKey($customer, $interval, $maxHits);

        $hits = (int) $this->redis->get($key);

        return $maxHits - $hits;
    }

    public function hit(Customer $customer, int $interval, int $maxHits): int
    {
        $key = $this->keyGenerator->getRateLimiterKey($customer, $interval, $maxHits);

        $res = $this->redis->multi()
            ->incr($key)
            ->expire($key, $interval * 60)
            ->exec();

        $hits = $res[0];

        if ($hits > $maxHits) {
            throw new ApiLimitReachedException();
        }

        return $maxHits - $hits;
    }
}
