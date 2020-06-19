<?php

namespace App\Service;

use App\Exception\AdvertisementNotFoundException;
use App\Value\Advertisement;
use App\Value\AdvertisementId;
use App\Value\CreateAdvertisement;

class AdvertisementService extends BaseService
{
    public function getByIdentifier(AdvertisementId $id): Advertisement
    {
        $advertisementKey = $this->keyGenerator->getAdvertisementKey($id);
        $data = $this->redis->hGetAll($advertisementKey);

        if (empty($data)) {
            throw new AdvertisementNotFoundException();
        }

        return $this->dataMapper->mapAdvertisement($id, $data);
    }

    public function getCount(): int
    {
        $advertisementsKey = $this->keyGenerator->getAdvertisementsKey();

        return (int)$this->redis->lLen($advertisementsKey);
    }

    public function getList(int $limit, int $offset = 0): array
    {
        $advertisementsKey = $this->keyGenerator->getAdvertisementsKey();

        $advertisements = [];

        $list = $this->redis->lRange($advertisementsKey, $offset, $limit);

        if (!is_array($list)) {
            return [];
        }

        foreach ($list as $item) {
            $datum = explode(":", $item);
            $advertisements[] = $datum[2];
        }

        return $advertisements;
    }

    public function remove(AdvertisementId $id): int
    {
        $advertisementKey = $this->keyGenerator->getAdvertisementKey($id);
        $advertisementsKey = $this->keyGenerator->getAdvertisementsKey();

        return (int)$this->redis->lRem($advertisementsKey, $advertisementKey, 0);
    }

    public function create(CreateAdvertisement $advertisement): Advertisement
    {
        $id = AdvertisementId::generate();

        $advertisementKey = $this->keyGenerator->getAdvertisementKey($id);

        $data = [
            'name' => $advertisement->getInfo()->getName(),
            'description' => $advertisement->getInfo()->getDescription(),
            'image' => $advertisement->getInfo()->getImage(),
            'latitude' => $advertisement->getLocation()->getLatitude(),
            'longitude' => $advertisement->getLocation()->getLongitude(),
            'customer' => $advertisement->getCustomer()->toString(),
        ];

        $this->redis->hMSet($advertisementKey, $data);

        $data = $this->redis->hGetAll($advertisementKey);

        $advertisementsKey = $this->keyGenerator->getAdvertisementsKey();

        $this->redis->lPush($advertisementsKey, $advertisementKey);

        $mostPopularKey = $this->keyGenerator->getMostPopularAdvertisementsKey();

        $this->redis->zAdd($mostPopularKey, [], 0, $advertisementKey);

        $advertisementsLocationsKey = $this->keyGenerator->getLocationsKey();
        $this->redis->geoadd(
            $advertisementsLocationsKey,
            $advertisement->getLocation()->getLongitude(),
            $advertisement->getLocation()->getLatitude(),
            $id
        );

        return $this->dataMapper->mapAdvertisement($id, $data);
    }
}
