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
            ->orderBy('event.date', 'DESC')
            ->getQuery()
        ;
    }
}
