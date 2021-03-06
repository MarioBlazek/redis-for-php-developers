<?php

declare(strict_types=1);

namespace App\Value;

class CreateAdvertisement
{
    /**
     * @var Location
     */
    private $location;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var Info
     */
    private $info;

    public function __construct(Info $info, Location $location, Customer $customer)
    {
        $this->location = $location;
        $this->customer = $customer;
        $this->info = $info;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getInfo(): Info
    {
        return $this->info;
    }
}
