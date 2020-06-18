<?php

namespace App\Value;

class Advertisement
{
    /**
     * @var AdvertisementId
     */
    private $advertisementId;

    /**
     * @var Info
     */
    private $info;

    /**
     * @var Location
     */
    private $location;

    /**
     * @var Customer
     */
    private $customer;

    public function __construct(AdvertisementId $advertisementId, Info $info, Location $location, Customer $customer)
    {
        $this->advertisementId = $advertisementId;
        $this->info = $info;
        $this->location = $location;
        $this->customer = $customer;
    }

    /**
     * @return AdvertisementId
     */
    public function getAdvertisementId(): AdvertisementId
    {
        return $this->advertisementId;
    }

    /**
     * @return Info
     */
    public function getInfo(): Info
    {
        return $this->info;
    }

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}
