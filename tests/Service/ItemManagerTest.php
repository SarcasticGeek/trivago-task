<?php

namespace App\Service;

use App\Constant\ItemCategory;
use App\Entity\Item;
use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ItemManagerTest extends KernelTestCase
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var ItemManagerInterface $itemManager */
    private $itemManager;
    /**
     * @var Generator $faker
     */
    private $faker;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->itemManager = self::$container->get(ItemManagerInterface::class);
        $this->faker = Factory::create();
    }

    public function testGetAll()
    {
        $data = $this->itemManager->getAll();

        self::assertTrue(is_array($data));
    }

    public function testDeleteOne()
    {
        $item = $this->makeMockItemObject();
        $deleted = $this->itemManager->deleteOne($item);

        self::assertTrue($deleted);
    }

    public function testCreate()
    {
        $output = $this->itemManager->create($this->makeMockItemObjectAsArray());

        self::assertInstanceOf(Item::class, isset($output['item'])? $output['item']:[]);
    }

    public function testUpdate()
    {
        $output = $this->itemManager->update(
            $this->makeMockItemObject(),
            $this->makeMockItemObjectAsArray()
        );

        self::assertInstanceOf(Item::class, isset($output['item'])? $output['item']:[]);
    }

    /**
     * @return Item
     */
    private function makeMockItemObject(): Item
    {
        $item = new Item();
        $item
            ->setName($this->faker->text(20))
            ->setRating($this->faker->numberBetween(0, 5))
            ->setCategory(ItemCategory::HOTEL)
            ->setImage($this->faker->imageUrl())
            ->setReputation($this->faker->numberBetween(0, 1000))
            ->setAvailability($this->faker->randomNumber(2))
            ->setPrice($this->faker->randomNumber(3))
            ->setLocation($this->entityManager->getRepository(Location::class)->findOneBy([]))
        ;

        $this->entityManager->persist($item);
        $this->entityManager->flush();

        return $item;
    }

    /**
     * @return array
     */
    private function makeMockItemObjectAsArray(): array
    {
        return [
            'name' => $this->faker->text(20),
            'rating' => $this->faker->numberBetween(0, 5),
            'category' => ItemCategory::HOTEL,
            'image' => $this->faker->imageUrl(),
            'reputation' => $this->faker->numberBetween(0, 1000),
            'availability' => $this->faker->randomNumber(2),
            'price' => $this->faker->randomNumber(3),
            'locationId' => $this->entityManager->getRepository(Location::class)->findOneBy([])->getId(),
        ];
    }
}
