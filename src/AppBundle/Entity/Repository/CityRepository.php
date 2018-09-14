<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity;

class CityRepository extends AbstractRepository
{
    /** @return Entity\City[][] */
    public function findForLanding()
    {
        $result = [
            'announced' => [],
            'unannounced' => [],
        ];

        /** @var Entity\City $city */
        foreach ($this->findAllWithEventsAndAnnouncements() as $city) {
            if ($city->hasValidAnnouncement()) {
                $result['announced'][] = $city;
            } else {
                if (false === $city->isDormant()) {
                    $result['unannounced'][] = $city;
                }
            }
        }

        return $result;
    }

    /** @return array|Entity\City[] */
    public function findForAnnouncementList()
    {
        return $this
            ->createQueryBuilder('c')
            ->leftJoin('c.announcements', 'a')
            ->leftJoin('a.lectures', 'l')
            ->leftJoin('l.lecturer', 'll')
            ->select(['c', 'a', 'l', 'll'])
            ->addOrderBy('c.name', 'ASC')
            ->addOrderBy('a.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /** @return array|Entity\City[] */
    public function findForList()
    {
        return $this
            ->createQueryBuilder('city')
            ->leftJoin('city.events', 'event')
            ->leftJoin('event.lectures', 'lecture')
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

    /** @return array|Entity\City[] */
    public function findAllWithEventsAndAnnouncements()
    {
        return array_reverse($this
            ->createQueryBuilder('c')
            ->leftJoin('c.events', 'e')
            ->leftJoin('c.announcements', 'a')
            ->leftJoin('a.lectures', 'l')
            ->leftJoin('l.lecturer', 'll')
            ->select(['c', 'a', 'e',  'l', 'll'])
            ->addOrderBy('a.date', 'DESC')
            ->getQuery()
            ->getResult()
        );
    }

    /** @return array|Entity\City[] */
    public function findAllWhichHaveLectures()
    {
        return $this
            ->createQueryBuilder('city')
            ->leftJoin('city.events', 'event')
            ->leftJoin('event.lectures', 'lecture')
            ->groupBy('city')
            ->having('COUNT(lecture.id) > 0')
            ->getQuery()
            ->getArrayResult()
        ;
    }

    public function findAllWithContacts()
    {
        return $this
            ->createQueryBuilder('city')
            ->innerJoin('city.contacts', "contacts")
            ->getQuery()
            ->getResult()
        ;
    }

}
