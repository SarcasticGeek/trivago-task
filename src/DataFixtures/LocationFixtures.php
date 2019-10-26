<?php

namespace App\DataFixtures;

use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LocationFixtures extends Fixture implements OrderedFixtureInterface
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $location = new Location();
        $location
            ->setCity($this->faker->city)
            ->setAddress($this->faker->address)
            ->setCountry($this->faker->country)
            ->setState($this->faker->country)
            ->setZipCode($this->faker->randomNumber(5))
        ;
        $manager->persist($location);
        $this->addReference('location-1', $location);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
