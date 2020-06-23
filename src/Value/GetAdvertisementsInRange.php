<?php

namespace App\Value;

class GetAdvertisementsInRange
{
    /**
     * @var Location
     */
    private $location;

    /**
     * @var Distance
     */
    private $distance;

    public function __construct(Location $location, Distance $distance)
    {
        $this->location = $location;
        $this->distance = $distance;
    }

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * @return Distance
     */
    public function getDistance(): Distance
    {
        return $this->distance;
    }
}
