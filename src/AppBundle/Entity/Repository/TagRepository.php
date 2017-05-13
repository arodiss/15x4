<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity;

class TagRepository extends AbstractRepository
{
    /**
     * @param int $count
     * @return array|Entity\Tag[]
     */
    public function findForCloud($count = 40)
    {
        return $this
            ->createQueryBuilder('tag')
            ->select('tag.id, tag.name')
            ->orderBy('tag.randomRating', 'DESC')
            ->setMaxResults($count)
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

    public function nullAllRating()
    {
        $this
            ->createQueryBuilder('tag')
            ->update()
            ->set('tag.randomRating', 0)
            ->getQuery()
            ->execute()
        ;
    }

    /** @return array|Entity\Tag[] */
    public function findAllWhichHas2PlusLectures()
    {
        return $this
            ->createQueryBuilder('tag')
            ->innerJoin('tag.lectures', 'l')
            ->having('COUNT(l) > 1')
            ->groupBy('tag')
            ->getQuery()
            ->getResult()
        ;
    }

    /** @return \Doctrine\ORM\QueryBuilder */
    public function getAdminQb()
    {
        return $this->createQueryBuilder('e')->orderBy('e.name', 'ASC');
    }
}
