<?php

namespace App\Controller;

use App\Service\AdvertisementService;
use App\Value\CreateAdvertisement;
use App\Value\Customer;
use App\Value\Info;
use App\Value\Location;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Redis;

class RedisController extends AbstractController
{
    /**
     * @Route("/redis", name="redis")
     */
    public function index(AdvertisementService $advertisementService)
    {
        $faker = Factory::create();
        $customer = Customer::generate();
        $location = new Location($faker->latitude,   $faker->longitude);
        $info = new Info($faker->text(25), $faker->text(150), $faker->image());

        $createAdvertisement = new CreateAdvertisement($info, $location, $customer);

        $advertisementService->create($createAdvertisement);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RedisController.php',
        ]);
    }
}
