<?php

namespace App\Service;

use App\Entity\Item;
use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;

class ItemManager implements ItemManagerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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

    public function create(array $data): Item
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

        $this->entityManager->persist($item);
        $this->entityManager->flush();

        return $item;
    }

    public function update(Item $item, array $data): Item
    {
        // TODO: Implement update() method.
    }

    private function getItemRepo()
    {
        return $this->entityManager->getRepository(Item::class);
    }
}
