<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity;

class CityRepository extends AbstractRepository
{
    /** @return array */
    public function findForList()
    {
        return $this
            ->createQueryBuilder('city')
            ->innerJoin('city.events', 'event')
            ->innerJoin('event.lectures', 'lecture')
            ->groupBy('city')
            ->select('city.id, city.name, COUNT(DISTINCT(event.id)) AS events_count')
            ->orderBy('events_count', 'DESC')
            ->getQuery()
            ->getArrayResult()
        ;
    }

    /** @return \Doctrine\ORM\QueryBuilder */
    public function getAdminQb()
    {
        return $this->createQueryBuilder('e');
    }
}
