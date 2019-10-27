<?php

namespace App\Controller\API;


use App\Entity\Item;
use App\Service\BookServiceInterface;
use App\Service\ItemManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ItemController
 * @package App\Controller\API
 * @Rest\Route("/api/item")
 */
class ItemController extends FOSRestController
{
    /**
     * @param ItemManagerInterface $itemManager
     * @param SerializerInterface $serializer
     * @return Response
     * @Rest\Get("/")
     */
    public function getAll(ItemManagerInterface $itemManager, SerializerInterface $serializer)
    {
        $items = $serializer->serialize($itemManager->getAll(), 'json');

        return new Response($items);
    }

    /**
     * @param Item $item
     * @param SerializerInterface $serializer
     * @return Response
     * @Rest\Get("/{item}")
     * @ParamConverter("item", class="App\Entity\Item")
     */
    public function getOne(Item $item, SerializerInterface $serializer)
    {
        $item = $serializer->serialize($item, 'json');

        return new Response($item);
    }

    /**
     * @Rest\Post("/")
     * @Rest\QueryParam(name="name", description="Name of Item.")
     * @Rest\QueryParam(name="rating", requirements="\d+", description="Rating of Item.")
     * @Rest\QueryParam(name="category", requirements="\d+", description="Category.")
     * @Rest\QueryParam(name="image", description="Image URL.")
     * @Rest\QueryParam(name="reputation", requirements="\d+", description="Reputation.")
     * @Rest\QueryParam(name="availability", requirements="\d+", description="Availability.")
     * @Rest\QueryParam(name="price", requirements="\d+", description="Price.")
     * @Rest\QueryParam(name="locationId", requirements="\d+", description="Id of Location")
     *
     * @param Request $request
     * @param ItemManagerInterface $itemManager
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function postOne(Request $request, ItemManagerInterface $itemManager, SerializerInterface $serializer)
    {
        $posted = $itemManager->create($this->convertRequestParametersToArray($request));

        if (isset($posted['item']) &&  $posted['item'] instanceof Item) {
            return new Response($serializer->serialize($posted['item'], 'json'), Response::HTTP_CREATED);
        }

        return new Response(isset($posted['errors'])? $posted['errors'] : [], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @Rest\Put("/{item}")
     * @ParamConverter("item", class="App\Entity\Item")
     * @Rest\QueryParam(name="name", description="Name of Item.")
     * @Rest\QueryParam(name="rating", requirements="\d+", description="Rating of Item.")
     * @Rest\QueryParam(name="category", requirements="\d+", description="Category.")
     * @Rest\QueryParam(name="image", description="Image URL.")
     * @Rest\QueryParam(name="reputation", requirements="\d+", description="Reputation.")
     * @Rest\QueryParam(name="availability", requirements="\d+", description="Availability.")
     * @Rest\QueryParam(name="price", requirements="\d+", description="Price.")
     * @Rest\QueryParam(name="locationId", requirements="\d+", description="Id of Location")
     * @param Item $item
     * @param Request $request
     * @param ItemManagerInterface $itemManager
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function updateOne(Item $item, Request $request, ItemManagerInterface $itemManager, SerializerInterface $serializer)
    {

        $updated = $itemManager->update($item, $this->convertRequestParametersToArray($request));

        if (isset($updated['item']) && $updated['item'] instanceof Item) {
            return new Response($serializer->serialize($item, 'json'), Response::HTTP_OK);
        }

        return new Response(isset($updated['errors'])? $updated['errors'] : [], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @Rest\Delete("/{item}")
     * @ParamConverter("item", class="App\Entity\Item")
     * @param Item $item
     * @param ItemManagerInterface $itemManager
     * @return JsonResponse
     */
    public function deleteOne(Item $item, ItemManagerInterface $itemManager)
    {
        $deleted = $itemManager->deleteOne($item);

        if ($deleted) {
            return new JsonResponse(['message' => 'Deleted'], Response::HTTP_OK);
        }

        return new JsonResponse([], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @Rest\Post("/{item}/book")
     * @ParamConverter("item", class="App\Entity\Item")
     * @param Item $item
     * @param BookServiceInterface $bookService
     * @return JsonResponse
     */
    public function book(Item $item, BookServiceInterface $bookService)
    {
        $booked = $bookService->book($item)? 'Booked' : 'Not Available';

        return new JsonResponse(['message' => $booked], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    private function convertRequestParametersToArray(Request $request)
    {
        $parametersAsArray = [];

        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        return $parametersAsArray;
    }
}