<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TestController
{
    /**
     * @Route("/api/test")
     */
    public function test()
    {
        return new JsonResponse(
            [
                'id' => 1,
            ],
            Response::HTTP_OK
        );
    }
}