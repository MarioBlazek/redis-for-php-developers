<?php

declare(strict_types=1);

namespace App\Controller\Advertisement;

use App\Service\AdvertisementService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CountController extends AbstractController
{
    /**
     * @Route("/advertisements-count", methods={"GET"}, name="mb_secure_advertisements_count")
     */
    public function view(AdvertisementService $advertisementService): JsonResponse
    {
        $count = $advertisementService->getCount();

        return $this->json(['count' => $count]);
    }
}
