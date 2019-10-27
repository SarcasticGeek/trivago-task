<?php

namespace App\Service;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookServiceTest extends KernelTestCase
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testBookIfAvailable()
    {
        /** @var Item $item */
        $item = $this->entityManager->getRepository(Item::class)->findOneBy([]);

        $bookService = new BookService($this->entityManager);
        $booked = $bookService->book($item);
        self::assertTrue($booked);
    }

    public function testBookIfNotAvailable()
    {
        /** @var Item $item */
        $item = $this->entityManager->getRepository(Item::class)->findOneBy([]);
        $item->setAvailability(0);

        $this->entityManager->persist($item);
        $bookService = new BookService($this->entityManager);
        $booked = $bookService->book($item);
        self::assertFalse($booked);
    }
}
