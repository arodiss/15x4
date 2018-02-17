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
     * @param array $langs
     * @return \Doctrine\ORM\Query
     */
    public function findByFilters(
        array $fields = [],
        array $tags = [],
        array $events = [],
        array $lecturers = [],
        array $langs = []
    ) {
        $qb = $this->createListQueryBuilder();
        $idGetter = function ($entity) {
            return $entity->getId();
        };

        if ($tags) {
            $qb->andWhere($qb->expr()->in('tag.id', array_map($idGetter, $tags)));
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
        if ($langs) {
            $qb->andWhere($qb->expr()->in('lecture.language', $langs));
        }

        return $qb->getQuery();
    }

    /** @return Entity\Lecture */
    public function getRandom()
    {
        $ids = array_column(
            $this
                ->createQueryBuilder('lecture')
                ->select('lecture.id')
                ->where('lecture.isFeatured = 1')
                ->getQuery()
                ->getArrayResult(),
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
        return $this
            ->createQueryBuilder('lecture')
            ->andWhere('lecture.isFeatured = 1')
            ->innerJoin('lecture.lecturer', 'lecturer')
            ->select(['lecture', 'lecturer'])
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
    public function findFeaturedMunich($number)
    {
        $qb = $this->createQueryBuilder('lecture');
        return $qb
            ->andWhere('lecture.isFeatured = 1')
            ->innerJoin('lecture.lecturer', 'lecturer')
            ->andWhere(
                $qb
                    ->expr()
                    ->orX(
                        $qb->expr()->eq('lecture.language', $qb->expr()->literal('en')),
                        $qb->expr()->eq('lecture.language', $qb->expr()->literal('de'))
                    )
            )
            ->select(['lecture', 'lecturer'])
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
            ->innerJoin('lecture.lecturer', 'lecturer')
            ->select(['lecture', 'lecturer'])
            ->orderBy('lecture.created', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /** @return \Doctrine\ORM\QueryBuilder */
    public function getAdminQb()
    {
        return $this->createQueryBuilder('l')->innerJoin('l.event', 'e')->orderBy('e.date', 'DESC');
    }

    /** @return \Doctrine\ORM\QueryBuilder */
    public function createListQueryBuilder()
    {
        return $this
            ->createQueryBuilder('lecture')
            ->innerJoin('lecture.field', 'field')
            ->innerJoin('lecture.event', 'event')
            ->innerJoin('event.city', 'city')
            ->innerJoin('lecture.lecturer', 'lecturer')
            ->leftJoin('lecture.tags', 'tag')
            ->select(['lecture', 'field', 'tag', 'event', 'lecturer', 'city'])
            ->orderBy('event.date', 'DESC')
        ;
    }

    /**
     * @param Entity\City $city
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQbByCity(Entity\City $city)
    {
        $qb = $this->getAdminQb();
        return $qb->innerJoin('e.city', 'c')->andWhere($qb->expr()->eq('c.id', $city->getId()));
    }
}
