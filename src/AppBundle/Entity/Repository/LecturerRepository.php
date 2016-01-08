<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity;
use Doctrine\ORM\EntityRepository;

class LecturerRepository extends EntityRepository
{
    /** @return array */
    public function findForList()
    {
        return $this
            ->createQueryBuilder('lecturer')
            ->innerJoin('lecturer.lectures', 'lecture')
            ->groupBy('lecturer')
            ->select('lecturer.id, lecturer.name, lecturer.bio, COUNT(lecture.id) AS lectures_count')
            ->orderBy('lectures_count', 'DESC')
            ->getQuery()
            ->getArrayResult()
        ;
    }
}
