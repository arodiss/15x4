<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class AbstractRepository extends EntityRepository
{
    /**
     * @param array $ids
     * @return array|object[]
     */
    public function findByIds(array $ids)
    {
        if (empty($ids)) {
            return [];
        }
        
        $qb = $this->createQueryBuilder('entity');

        return $qb
            ->where($qb->expr()->in('entity.id ', $ids))
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param array $excludeIds
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createQueryBuilderWithExcludeIds(array $excludeIds)
    {
        $qb = $this->createQueryBuilder('entity');

        return $qb->where($qb->expr()->notIn('entity.id', $excludeIds));
    }
}
