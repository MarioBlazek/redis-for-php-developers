<?php

namespace App\Util;

use App\Value\AdvertisementId;
use App\Value\Customer;

class KeyGenerator
{
    /**
     * @var string
     */
    private $prefix;

    /**
     * @var TimeUtil
     */
    private $timeUtil;

    public function __construct(TimeUtil $timeUtil, string $prefix = 'marek_app')
    {
        $this->prefix = $prefix;
        $this->timeUtil = $timeUtil;
    }

    public function getAdvertisementKey(AdvertisementId $advertisementId): string
    {
        return sprintf("%s:advertisement:%s", $this->prefix, $advertisementId->toString());
    }

    public function getAdvertisementsKey(): string
    {
        return sprintf("%s:advertisements", $this->prefix);
    }

    public function getMostPopularAdvertisementsKey(): string
    {
        return sprintf("%s:most_popular_advertisements", $this->prefix);
    }

    public function getRateLimiterKey(Customer $customer, int $interval, int $maxHits): string
    {
        $minuteOfTheDay = $this->timeUtil->getMinuteOfTheDay();

        $intervals = intval($minuteOfTheDay / $interval);

        return sprintf("%s:limiter:%s:%d:%d", $this->prefix, $customer->toString(), $intervals, $maxHits);
    }

    public function getPrefixKeyPattern(): string
    {
        return sprintf("%s:*", $this->prefix);
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }
}
