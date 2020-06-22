<?php

declare(strict_types=1);

namespace App\Util;

use App\Value\Advertisement;
use App\Value\AdvertisementId;
use App\Value\Customer;
use App\Value\Info;
use App\Value\Location;

class DataMapper
{
    public function serializeAdvertisement(Advertisement $advertisement): array
    {
        return [
            'id' => $advertisement->getAdvertisementId()->toString(),
            'name' => $advertisement->getInfo()->getName(),
            'description' => $advertisement->getInfo()->getDescription(),
            'image' => $advertisement->getInfo()->getImage(),
            'latitude' => $advertisement->getLocation()->getLatitude(),
            'longitude' => $advertisement->getLocation()->getLongitude(),
            'customer' => $advertisement->getCustomer()->toString(),
        ];
    }

    public function mapAdvertisement(AdvertisementId $advertisementId, array $data): Advertisement
    {
        $info = new Info(
            $data['name'],
            $data['description'],
            $data['image']
        );

        $location = new Location(
            $data['latitude'],
            $data['longitude']
        );

        $customer = new Customer(
            $data['customer']
        );

        return new Advertisement($advertisementId, $info, $location, $customer);
    }
}
