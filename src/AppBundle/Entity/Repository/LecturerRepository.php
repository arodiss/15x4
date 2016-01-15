<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity;

class LecturerRepository extends AbstractRepository
{
    /** @return \Doctrine\ORM\Query */
    public function findForList()
    {
        return $this
            ->createQueryBuilder('lecturer')
            ->innerJoin('lecturer.lectures', 'lecture')
            ->groupBy('lecturer')
            ->select('lecturer.id, lecturer.name, lecturer.bio, COUNT(lecture.id) AS lectures_count')
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
}
