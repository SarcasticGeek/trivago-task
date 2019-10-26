<?php

namespace App\Service;

use App\Entity\Item;
use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ItemManager implements ItemManagerInterface
{
    private $entityManager;

    private $serializer;

    private $validator;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function getAll(): array
    {
        return $this->getItemRepo()->findAll();
    }

    public function deleteOne(Item $item): bool
    {
        if (!$item) {
            return false;
        }

        $this->entityManager->remove($item);
        $this->entityManager->flush();

        return true;
    }

    public function create(array $data)
    {
        $item = new Item();
        $item
            ->setName($data['name'])
            ->setRating($data['rating'])
            ->setCategory($data['category'])
            ->setImage($data['image'])
            ->setReputation($data['reputation'])
            ->setAvailability($data['availability'])
            ->setPrice($data['price'])
            ->setLocation($this->entityManager->getReference(Location::class, $data['locationId']))
        ;

        $errors = $this->validator->validate($item);

        if(count($errors) > 0) {
            return $errors;
        }

        $this->entityManager->persist($item);
        $this->entityManager->flush();

        return $item;
    }

    public function update(Item $item, string $data): Item
    {
        /** @var Item $deserializedItem */
        $deserializedItem = $this->serializer->deserialize($data, Item::class, 'json');

        $this->entityManager->persist($deserializedItem);
        $this->entityManager->flush();

        return $deserializedItem;
    }

    private function getItemRepo()
    {
        return $this->entityManager->getRepository(Item::class);
    }
}
