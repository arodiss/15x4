<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity;

class LectureRepository extends AbstractRepository
{
    /**
     * @param array $fields
     * @param array $tags
     * @param array $events
     * @param array $lecturers
     * @return \Doctrine\ORM\Query
     */
    public function findByFilters(array $fields = [], array $tags = [], array $events = [], array $lecturers = [])
    {
        $qb = $this
            ->createQueryBuilder('lecture')
            ->innerJoin('lecture.event', 'event')
            ->orderBy('event.date', 'DESC')
        ;

        $idGetter = function ($entity) {
            return $entity->getId();
        };

        if ($tags) {
            $qb
                ->innerJoin('lecture.tags', 'tag')
                ->andWhere($qb->expr()->in('tag.id', array_map($idGetter, $tags)))
            ;
        }
        if ($fields) {
            $qb->andWhere($qb->expr()->in('lecture.field', array_map($idGetter, $fields)));
        }
        if ($events) {
            $qb->andWhere($qb->expr()->in('lecture.event', array_map($idGetter, $events)));
        }
        if ($lecturers) {
            $qb->andWhere($qb->expr()->in('lecture.lecturer', array_map($idGetter, $lecturers)));
        }

        return $qb->getQuery();
    }

    /** @return Entity\Lecture */
    public function getRandom()
    {
        $ids = array_column(
            $this->createQueryBuilder('lecture')->select('lecture.id')->getQuery()->getArrayResult(),
            'id'
        );

        return $this->find($ids[array_rand($ids)]);
    }

    /**
     * @param int $number
     * @return Entity\Lecture[]
     */
    public function findFeatured($number)
    {
        return  $this
            ->createQueryBuilder('lecture')
            ->andWhere('lecture.isFeatured = 1')
            ->setMaxResults($number)
            ->orderBy('lecture.randomRating', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param int $number
     * @return Entity\Lecture[]
     */
    public function findRecent($number)
    {
        $qb = $this->createQueryBuilder('lecture');

        return $qb
            ->setMaxResults($number)
            ->innerJoin('lecture.event', 'event')
            ->orderBy('event.created', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /** @return \Doctrine\ORM\QueryBuilder */
    public function getAdminQb()
    {
        return $this->createQueryBuilder('l')->innerJoin('l.event', 'e')->orderBy('e.date', 'DESC');
    }
}
