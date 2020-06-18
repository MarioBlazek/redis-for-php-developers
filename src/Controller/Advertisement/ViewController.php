<?php

namespace App\Controller\Advertisement;

use App\Service\AdvertisementService;
use App\Service\MostPopularAdvertisementService;
use App\Util\DataMapper;
use App\Value\AdvertisementId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    /**
     * @Route(
     *     "/advertisement/view/{id}",
     *      methods={"GET"},
     *      name="mb_secure_advertisement_view"
     * )
     */
    public function view(
        AdvertisementService $advertisementService,
        MostPopularAdvertisementService $mostPopularAdvertisementService,
        DataMapper $dataMapper, string $id
    )
    {
        $identifier = new AdvertisementId($id);

        $advertisement = $advertisementService->getByIdentifier($identifier);
        $mostPopularAdvertisementService->increaseRankForAdvertisement($identifier);

        $data = $dataMapper->serializeAdvertisement($advertisement);

        return $this->json($data);
    }
}
