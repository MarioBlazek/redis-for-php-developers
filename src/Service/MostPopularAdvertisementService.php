<?php

declare(strict_types=1);

namespace App\Service;

use App\Value\AdvertisementId;

class MostPopularAdvertisementService extends BaseService
{
    public function increaseRankForAdvertisement(AdvertisementId $advertisementId): void
    {
        $mostPopularAdvertisementsKey = $this->keyGenerator->getMostPopularAdvertisementsKey();
        $advertisementKey = $this->keyGenerator->getAdvertisementKey($advertisementId);

        $this->redis->zIncrBy($mostPopularAdvertisementsKey, 1, $advertisementKey);
    }

    public function getMostPopular(int $limit): array
    {
        $mostPopularAdvertisementsKey = $this->keyGenerator->getMostPopularAdvertisementsKey();

        $list = $this->redis->zRevRange($mostPopularAdvertisementsKey, 0, $limit, true);
        $advertisements = [];

        foreach ($list as $key => $value) {
            $datum = explode(':', $key);
            $advertisements[$datum[2]] = $value;
        }

        return $advertisements;
    }
}
