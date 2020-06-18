<?php

namespace App\Controller\Advertisement;

use App\Service\AdvertisementService;
use App\Value\AdvertisementId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RemoveController extends AbstractController
{
    /**
     * @Route(
     *     "/advertisement/remove/{id}",
     *      methods={"GET"},
     *      requirements={"id"="\w+"},
     *      name="mb_secure_advertisement_remove"
     * )
     */
    public function remove(AdvertisementService $advertisementService, string $id)
    {
        $identifier = new AdvertisementId($id);

        $advertisementService->remove($identifier);

        return $this->json([]);
    }
}
