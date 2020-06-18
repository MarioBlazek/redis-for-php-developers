<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="mb_welcome")
     */
    public function welcome()
    {
        $response = [
            'name' => 'Simple Redis project',
            'description' => 'This is a simple Symfony project that showcases some of the Redis functionalities',
        ];

        return $this->json($response);
    }
}
