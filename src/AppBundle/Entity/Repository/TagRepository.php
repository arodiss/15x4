<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity;

class TagRepository extends AbstractRepository
{
    /** @return \Doctrine\ORM\Query */
    public function findForList()
    {
        return $this
            ->createQueryBuilder('tag')
            ->innerJoin('tag.lectures', 'lecture')
            ->groupBy('tag')
            ->select('tag.id, tag.name, COUNT(lecture.id) AS lectures_count')
            ->orderBy('lectures_count', 'DESC')
            ->getQuery()
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
