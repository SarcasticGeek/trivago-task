<?php

namespace App\Service;

use App\Entity\Item;
use App\Entity\Location;
use App\Repository\ItemRepositoryInterface;
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

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->getItemRepo()->findAll();
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function deleteOne(Item $item): bool
    {
        if (!$item) {
            return false;
        }

        $this->entityManager->remove($item);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @param array $data
     * @return array
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(array $data): array
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
            return ['errors' => $errors];
        }

        $this->entityManager->persist($item);
        $this->entityManager->flush();

        return ['item' => $item];
    }

    /**
     * @param Item $item
     * @param array $data
     * @return array
     * @throws \Doctrine\ORM\ORMException
     */
    public function update(Item $item, array $data): array
    {
        $item
            ->setName(isset($data['name'])? $data['name'] : $item->getName())
            ->setRating(isset($data['rating'])? $data['rating'] : $item->getRating())
            ->setCategory(isset($data['category'])? $data['category'] : $item->getCategory())
            ->setImage(isset($data['image'])? $data['image'] : $item->getImage())
            ->setReputation(isset($data['reputation'])? $data['reputation'] : $item->getReputation())
            ->setAvailability(isset($data['availability'])? $data['availability'] : $item->getAvailability())
            ->setPrice(isset($data['price'])? $data['price'] : $item->getPrice())
            ->setLocation(
                isset($data['locationId']) && $this->entityManager->getReference(Location::class, $data['locationId']) ?
                    $this->entityManager->getReference(Location::class, $data['locationId']) : $item->getLocation()
            )
        ;

        $errors = $this->validator->validate($item);

        if(count($errors) > 0) {
            return ['errors' => $errors];
        }

        $this->entityManager->persist($item);
        $this->entityManager->flush();

        return ['item' => $item];
    }

    /**
     * @param array $filters
     * @return array
     */
    public function findBy(array $filters): array
    {
        return $this->getItemRepo()->search($filters);
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function getItemRepo()
    {
        return $this->entityManager->getRepository(Item::class);
    }
}
