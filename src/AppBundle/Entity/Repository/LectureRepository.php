<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity;
use Doctrine\ORM\EntityRepository;

class LectureRepository extends EntityRepository
{
    /**
     * @param Entity\City $city
     * @return Entity\Lecture[]
     */
    public function findByCity(Entity\City $city)
    {
        $qb = $this->createQueryBuilder("lecture");

        return $qb
            ->innerJoin("lecture.event", "event")
            ->andWhere($qb->expr()->eq("event.city", ":city"))
            ->setParameter("city", $city)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param Entity\Tag $tag
     * @return Entity\Lecture[]
     */
    public function findByTag(Entity\Tag $tag)
    {
        $qb = $this->createQueryBuilder("lecture");

        return $qb
            ->andWhere(":tag MEMBER OF lecture.tags")
            ->setParameter("tag", $tag)
            ->getQuery()
            ->getResult()
        ;
    }
}
