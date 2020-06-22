<?php

declare(strict_types=1);

namespace App\Controller\Advertisement;

use App\Service\AdvertisementService;
use App\Value\AdvertisementId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RemoveController extends AbstractController
{
    /**
     * @Route(
     *     "/advertisement/remove/{id}",
     *      methods={"GET"},
     *      name="mb_secure_advertisement_remove"
     * )
     */
    public function remove(AdvertisementService $advertisementService, string $id): JsonResponse
    {
        $identifier = new AdvertisementId($id);

        $count = $advertisementService->remove($identifier);

        return $this->json(['removed' => $count]);
    }
}
