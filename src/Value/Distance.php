<?php

namespace App\Value;

class Distance
{
    public const UNIT_METERS = 'm';
    public const UNIT_KILOMETERS = 'km';

    /**
     * @var float
     */
    private $distance;

    /**
     * @var string
     */
    private $unit;

    public function __construct(float $distance, string $unit = self::UNIT_KILOMETERS)
    {
        $this->distance = $distance;
        $this->unit = $unit;
    }

    /**
     * @return float
     */
    public function getDistance(): float
    {
        return $this->distance;
    }

    /**
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }
}
