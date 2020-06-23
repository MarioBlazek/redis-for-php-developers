<?php

namespace App\Controller\Geospatial;

use App\Service\GeospatialService;
use App\Value\Distance;
use App\Value\GetAdvertisementsInRange;
use App\Value\Location;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class InRangeController extends AbstractController
{
    /**
     * @Route(
     *     "/geospatial/in-range/km/{latitude}/{longitude}/{distance}",
     *      methods={"GET"},
     *      name="mb_secure_geospatial_km"
     * )
     */
    public function inRange(GeospatialService $geospatialService, float $latitude, float $longitude, float $distance): JsonResponse
    {
        try {
            $location = new Location($latitude, $longitude);
            $distance = new Distance($distance);
            $advertisementsInRange = new GetAdvertisementsInRange($location, $distance);

            $data = $geospatialService->getInRange($advertisementsInRange);

            return $this->json($data);
        } catch (\Exception $exception) {
            return new JsonResponse([], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route(
     *     "/geospatial/in-range/m/{latitude}/{longitude}/{distance}",
     *      methods={"GET"},
     *      name="mb_secure_geospatial_m"
     * )
     */
    public function inRangeMeters(GeospatialService $geospatialService, float $latitude, float $longitude, float $distance): JsonResponse
    {
        try {
            $location = new Location($latitude, $longitude);
            $distance = new Distance($distance, Distance::UNIT_METERS);
            $advertisementsInRange = new GetAdvertisementsInRange($location, $distance);

            $data = $geospatialService->getInRange($advertisementsInRange);

            return $this->json($data);
        } catch (\Exception $exception) {
            return new JsonResponse([], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
