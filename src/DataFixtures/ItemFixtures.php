<?php

namespace App\DataFixtures;

use App\Constant\ItemCategory;
use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ItemFixtures extends Fixture implements OrderedFixtureInterface
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
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
            ->setLocation($this->getReference('location-1'))
        ;
        $manager->persist($item);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
