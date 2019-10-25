<?php

namespace App\Controller\API;


use App\Service\DemoManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DemoAPIController
 * @package App\Controller\API
 * @Rest\Route("/api")
 */
class DemoAPIController extends FOSRestController
{
    /**
     * @Rest\Get("/demo")
     * @param DemoManagerInterface $demoManager
     * @return JsonResponse
     */
    public function demoAction(DemoManagerInterface $demoManager)
    {
        return new JsonResponse([
            "id" => 1,
            "value" => $demoManager->hey()
        ]);
    }

}