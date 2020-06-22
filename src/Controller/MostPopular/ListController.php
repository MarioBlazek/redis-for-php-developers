<?php

declare(strict_types=1);

namespace App\Controller\MostPopular;

use App\Service\MostPopularAdvertisementService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @Route(
     *     "/most-popular/{limit}",
     *      methods={"GET"},
     *      requirements={"limit"="\d+", "offset"="\d+"},
     *      name="mb_secure_most_popular"
     * )
     */
    public function view(MostPopularAdvertisementService $mostPopularAdvertisementService, int $limit = 100)
    {
        $list = $mostPopularAdvertisementService->getMostPopular($limit);

        return $this->json($list);
    }
}
