<?php

namespace App\Repository;

use App\Constant\ReputationBadge;
use Doctrine\ORM\EntityRepository;

/**
 * ItemRepository
 */
class ItemRepository extends EntityRepository implements ItemRepositoryInterface
{
    /**
     * @param array $criteria
     * @return array
     *
     * TODO: there are in the method if conditions makes the code smells, so I will refactor it with filter pattern.
     */
    public function search(array $criteria = []): array
    {
        $queryBuilder = $this->createQueryBuilder('item');

        if (!empty($criteria['rating'])) {
           $queryBuilder->andWhere($queryBuilder->expr()->eq('item.rating', $criteria['rating']));
        }

        if (!empty($criteria['reputationBadge'])) {
            switch ($criteria['reputationBadge']) {
                case ReputationBadge::RED:
                    $reputationBetween = [1,500];
                    break;
                case ReputationBadge::YELLOW:
                    $reputationBetween = [501,799];
                    break;
                default:
                    $reputationBetween = [800,1000];
                    break;
            }
            $queryBuilder->andWhere($queryBuilder->expr()->between(
                'item.reputation', $reputationBetween[0], $reputationBetween[1]
            ));
        }

        if (!empty($criteria['availabilityMoreThan'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->gt(
                'item.availability', $criteria['availabilityMoreThan']
            ));
        }

        if (!empty($criteria['availabilityLessThan'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->lt(
                'item.availability', $criteria['availabilityLessThan']
            ));
        }

        if (!empty($criteria['category'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('item.category', ':category'))
                ->setParameter('category', $criteria['category'])
            ;
        }

        if (!empty($criteria['city'])) {
            $queryBuilder->leftJoin('item.location', 'location')
                ->andWhere($queryBuilder->expr()->eq('location.city', ':city'))
                ->setParameter('city', $criteria['city'])
            ;
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
