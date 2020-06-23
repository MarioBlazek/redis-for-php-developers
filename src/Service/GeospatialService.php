<?php

namespace App\Service;

use App\Value\GetAdvertisementsInRange;

class GeospatialService extends BaseService
{
    public function getInRange(GetAdvertisementsInRange $advertisementsInRange): array
    {
        $advertisementsLocationsKey = $this->keyGenerator->getLocationsKey();

        $data = $this->redis->georadius(
            $advertisementsLocationsKey,
            $advertisementsInRange->getLocation()->getLongitude(),
            $advertisementsInRange->getLocation()->getLatitude(),
            $advertisementsInRange->getDistance()->getDistance(),
            $advertisementsInRange->getDistance()->getUnit()
        );

        return $data;
    }
}
