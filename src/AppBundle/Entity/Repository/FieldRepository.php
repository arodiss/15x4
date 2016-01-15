<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Field;

class FieldRepository extends AbstractRepository
{
    /**
     * @param Field|null $field
     * @return array
     */
    public function findWithTags(Field $field = null)
    {
        //todo add caching

        $qb = $this->createQueryBuilder('field');

        if ($field) {
            //needs to execute query with join anyway
            $qb->andWhere($qb->expr()->eq('field.id', $field->getId()));
        }

        $fields = $qb
            ->innerJoin('field.lectures', 'lecture')
            ->groupBy('field')
            ->select('field.id', 'field.name', 'COUNT(lecture.id) AS lecture_count')
            ->orderBy('lecture_count', 'DESC')
            ->getQuery()
            ->getArrayResult()
        ;

        foreach ($fields as &$field) {
            $qb = $this->createQueryBuilder('field');

            $tags = $qb
                ->andWhere($qb->expr()->eq('field.id', $field['id']))
                ->innerJoin('field.lectures', 'lecture')
                ->innerJoin('lecture.tags', 'tag')
                ->groupBy('tag')
                ->select([
                    'tag.id',
                    'tag.name',
                    'COUNT(lecture.id) AS lecture_count',
                ])
                ->orderBy('lecture_count', 'DESC')
                ->getQuery()
                ->getArrayResult()
            ;

            $field['tags'] = $tags;
        }

        return $fields;
    }

    /**
     * @param array $excludeIds
     * @return array
     */
    public function findForFilter(array $excludeIds)
    {
        $qb = $this->createQueryBuilderWithExcludeIds($excludeIds);

        return $qb
            ->select('entity.id, entity.name')
            ->getQuery()
            ->getArrayResult()
        ;
    }
}
