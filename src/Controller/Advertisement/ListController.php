<?php

declare(strict_types=1);

namespace App\Controller\Advertisement;

use App\Service\AdvertisementService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @Route(
     *     "/advertisements/{limit}/{offset}",
     *      methods={"GET"},
     *      requirements={"limit"="\d+", "offset"="\d+"},
     *      name="mb_secure_advertisements"
     * )
     */
    public function view(AdvertisementService $advertisementService, int $limit = 100, int $offset = 0): JsonResponse
    {
        $list = $advertisementService->getList($limit, $offset);

        return $this->json($list);
    }
}
