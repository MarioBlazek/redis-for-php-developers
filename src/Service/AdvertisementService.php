<?php

namespace App\Service;

use App\Value\Advertisement;
use App\Value\AdvertisementId;
use App\Value\CreateAdvertisement;

class AdvertisementService extends BaseService
{
    public function getByIdentifier(AdvertisementId $id): Advertisement
    {
        $advertisementKey = $this->keyGenerator->getAdvertisementKey($id);
        $data = $this->redis->hGetAll($advertisementKey);

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

        foreach ($list as $item) {
            $datum = explode(":", $item);
            $advertisements[] = $datum[2];
        }

        return $advertisements;
    }

    public function remove(AdvertisementId $id): void
    {
        $advertisementKey = $this->keyGenerator->getAdvertisementKey($id);
        $advertisementsKey = $this->keyGenerator->getAdvertisementsKey();

        $this->redis->lRem($advertisementsKey, $advertisementKey, 0);
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

        $this->redis->sAdd($advertisementsKey, $advertisementKey);

        $mostPopularKey = $this->keyGenerator->getMostPopularAdvertisementsKey();

        $this->redis->zAdd($mostPopularKey, [], 0, $advertisementKey);

        return $this->dataMapper->mapAdvertisement($id, $data);
    }
}
