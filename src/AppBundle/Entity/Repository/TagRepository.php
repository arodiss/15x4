<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity;

class TagRepository extends AbstractRepository
{
    /** @return \Doctrine\ORM\Query */
    public function findForCloud()
    {
        return $this
            ->createQueryBuilder('tag')
            ->select('tag.id, tag.name')
            ->orderBy('tag.randomRating', 'DESC')
            ->setMaxResults(40)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param array $excludeIds
     * @return array
     */
    public function findForFilter(array $excludeIds)
    {
        $qb = $this->createQueryBuilderWithExcludeIds($excludeIds);

        return $qb
            ->select('entity.id, entity.name')
            ->orderBy('entity.name', 'ASC')
            ->getQuery()
            ->getArrayResult()
        ;
    }

    /** @return \Doctrine\ORM\QueryBuilder */
    public function getAdminQb()
    {
        return $this->createQueryBuilder('e')->orderBy('e.name', 'ASC');
    }
}
