<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\City;
use AppBundle\Entity\Event;
use Doctrine\ORM\EntityRepository;

class EventRepository extends EntityRepository
{
    /**
     * @param City $city
     * @return \Doctrine\ORM\Query
     */
    public function findForList(City $city)
    {
        $qb = $this->createQueryBuilder('event');

        return $qb
            ->andWhere($qb->expr()->eq('event.city', $city->getId()))
            ->leftJoin('event.lectures', 'lecture')
            ->leftJoin('lecture.field', 'field')
            ->select('event.date', 'event.id', 'GROUP_CONCAT(field.name) as fields')
            ->orderBy('event.date', 'DESC')
            ->getQuery()
        ;
    }
}
