<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class FieldRepository extends EntityRepository
{
    /** @return array */
    public function findWithTags()
    {
        //todo add caching

        $fields = $this
            ->createQueryBuilder("field")
            ->select("field.id", "field.name")
            ->getQuery()
            ->getArrayResult()
        ;
        foreach ($fields as &$field) {
            $qb = $this->createQueryBuilder("field");

            $tags = $qb
                ->andWhere($qb->expr()->eq("field.id", $field["id"]))
                ->innerJoin("field.lectures", "lecture")
                ->innerJoin("lecture.tags", "tag")
                ->groupBy("tag")
                ->select([
                    "tag.id",
                    "tag.name",
                    "COUNT(lecture.id) AS lecture_count",
                ])
                ->getQuery()
                ->getArrayResult()
            ;

            $field["tags"] = $tags;
        }

        return $fields;
    }
}
