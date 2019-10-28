<?php

namespace App\Repository;

use App\Constant\ItemCategory;
use App\Constant\ReputationBadge;
use App\Entity\Item;
use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ItemRepositoryTest extends KernelTestCase
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /**
     * @var Generator $faker
     */
    private $faker;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->faker = Factory::create();
    }

    public function testSearchByRating()
    {
        $item = $this->makeMockItemObject();
        $output = $this->entityManager->getRepository(Item::class)->search(['rating' => 3]);

        self::assertIsArray($output);

        $this->entityManager->remove($item);
    }

    public function testSearchByReputationBadge()
    {
        $item = $this->makeMockItemObject();
        $output = $this->entityManager->getRepository(Item::class)->search(['reputationBadge' => ReputationBadge::RED]);

        self::assertIsArray($output);

        $this->entityManager->remove($item);
    }

    public function testSearchByAvailabilityMoreThan()
    {
        $item = $this->makeMockItemObject();
        $output = $this->entityManager->getRepository(Item::class)->search(['availabilityMoreThan' => 400]);

        self::assertIsArray($output);

        $this->entityManager->remove($item);
    }

    public function testSearchByAvailabilityLessThan()
    {
        $item = $this->makeMockItemObject();
        $output = $this->entityManager->getRepository(Item::class)->search(['availabilityLessThan' => 510]);

        self::assertIsArray($output);

        $this->entityManager->remove($item);
    }

    public function testSearchByCategory()
    {
        $item = $this->makeMockItemObject();
        $output = $this->entityManager->getRepository(Item::class)->search(['category' => ItemCategory::HOTEL]);

        self::assertIsArray($output);

        $this->entityManager->remove($item);
    }

    public function testSearchByCity()
    {
        $item = $this->makeMockItemObject();
        $output = $this->entityManager->getRepository(Item::class)->search(['city' => 'cairo']);

        self::assertIsArray($output);

        $this->entityManager->remove($item);
    }

    /**
     * @return Item
     */
    private function makeMockItemObject(): Item
    {
        $location = new Location();

        $location
            ->setCity('cairo')
            ->setAddress($this->faker->address)
            ->setCountry($this->faker->country)
            ->setState($this->faker->country)
            ->setZipCode($this->faker->randomNumber(5))
        ;
        $this->entityManager->persist($location);

        $item = new Item();
        
        $item
            ->setName($this->faker->text(20))
            ->setRating(3)
            ->setCategory(ItemCategory::HOTEL)
            ->setImage($this->faker->imageUrl())
            ->setReputation(400)
            ->setAvailability(500)
            ->setPrice($this->faker->randomNumber(3))
            ->setLocation($location)
        ;

        $this->entityManager->persist($item);
        $this->entityManager->flush();

        return $item;
    }
}
