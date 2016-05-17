<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\City;

class EventRepository extends AbstractRepository
{
    /**
     * @param City $city
     * @return \Doctrine\ORM\Query
     */
    public function findForList(City $city)
    {
        $qb = $this->createQueryBuilder('event');

        return $qb
            ->innerJoin('event.lectures', 'lecture')
            ->andWhere($qb->expr()->eq('event.city', $city->getId()))
            ->orderBy('event.date', 'DESC')
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
            ->innerJoin('entity.city', 'city')
            ->select('entity.id, entity.date, city.name AS city_name')
            ->orderBy('entity.date', 'DESC')
            ->getQuery()
            ->getArrayResult()
        ;
    }

    /** @return \Doctrine\ORM\QueryBuilder */
    public function getAdminQb()
    {
        return $this->createQueryBuilder('e')->orderBy('e.date', 'DESC');
    }

    /**
     * @param int $number
     * @return array
     */
    public function findRecent($number)
    {
        return $this
            ->createQueryBuilder('event')
            ->leftJoin('event.lectures', 'lecture')
            ->groupBy('event')
            ->having('COUNT(lecture) > 0')
            ->setMaxResults($number)
            ->orderBy('event.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
