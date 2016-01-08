<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity;
use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository
{
    /** @return array */
    public function findForList()
    {
        return $this
            ->createQueryBuilder('tag')
            ->innerJoin('tag.lectures', 'lecture')
            ->groupBy('tag')
            ->select('tag.id, tag.name, COUNT(lecture.id) AS lectures_count')
            ->orderBy('lectures_count', 'DESC')
            ->getQuery()
            ->getArrayResult()
        ;
    }
}
