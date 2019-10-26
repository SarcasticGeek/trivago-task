<?php

namespace App\Service;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;

class BookService implements BookServiceInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function book(Item $item): bool
    {
        if ($item->getAvailability()) {
            $item->setAvailability($item->getAvailability() - 1);
            $this->entityManager->persist($item);
            $this->entityManager->flush();

            return true;
        }

        return false;
    }
}
