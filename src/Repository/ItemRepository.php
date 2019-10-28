<?php

namespace App\Repository;

use App\Constant\ReputationBadge;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * ItemRepository
 */
class ItemRepository extends EntityRepository implements ItemRepositoryInterface
{
    /**
     * @param array $criteria
     * @return array
     */
    public function search(array $criteria = []): array
    {
        $queryBuilder = $this->createQueryBuilder('item');

        foreach ($criteria as $key => $value) {
            if (method_exists($this, 'filterBy'.ucfirst($key))) {
                $this->{'filterBy'.ucfirst($key)}($queryBuilder, $value);
            }
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param int $value
     * @return QueryBuilder
     */
    private function filterByRating(QueryBuilder $queryBuilder , int $value): QueryBuilder
    {
        return $queryBuilder->andWhere($queryBuilder->expr()->eq('item.rating', $value));
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $value
     * @return QueryBuilder
     */
    private function filterByReputationBadge(QueryBuilder $queryBuilder, string $value): QueryBuilder
    {
        switch ($value) {
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

        return $queryBuilder->andWhere($queryBuilder->expr()->between(
            'item.reputation', $reputationBetween[0], $reputationBetween[1]
        ));
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param int $value
     * @return QueryBuilder
     */
    private function filterByAvailabilityMoreThan(QueryBuilder $queryBuilder, int $value): QueryBuilder
    {
        return $queryBuilder->andWhere($queryBuilder->expr()->gt('item.availability', $value));
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param int $value
     * @return QueryBuilder
     */
    private function filterByAvailabilityLessThan(QueryBuilder $queryBuilder, int $value): QueryBuilder
    {
        return $queryBuilder->andWhere($queryBuilder->expr()->lt('item.availability', $value));
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $value
     * @return QueryBuilder
     */
    private function filterByCategory(QueryBuilder $queryBuilder, string $value): QueryBuilder
    {
        return $queryBuilder
            ->andWhere($queryBuilder->expr()->eq('item.category', ':category'))
            ->setParameter('category', $value)
        ;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $value
     * @return QueryBuilder
     */
    private function filterByCity(QueryBuilder $queryBuilder, string $value): QueryBuilder
    {
        return $queryBuilder->leftJoin('item.location', 'location')
            ->andWhere($queryBuilder->expr()->eq('location.city', ':city'))
            ->setParameter('city', $value)
        ;
    }
}
