<?php

namespace AppBundle\Entity\Repository;

class ContactRepository extends AbstractRepository
{
    /** @return \Doctrine\ORM\QueryBuilder */
    public function getAdminQb()
    {
        return $this
            ->createQueryBuilder('contact')
            ->select('city, contact')
            ->leftJoin('contact.city', 'city')
            ->orderBy('city.name', 'ASC')
        ;
    }
}
