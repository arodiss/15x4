<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Repository;

class AbstractController extends Controller
{
    /** @return Repository\LectureRepository */
    protected function getLectureRepository()
    {
        return $this->get('repository.lecture');
    }

    /** @return Repository\LecturerRepository */
    protected function getLecturerRepository()
    {
        return $this->get('repository.lecturer');
    }

    /** @return Repository\EventRepository */
    protected function getEventRepository()
    {
        return $this->get("repository.event");
    }

    /** @return Repository\FieldRepository */
    protected function getFieldRepository()
    {
        return $this->get("repository.field");
    }

    /** @return Repository\TagRepository */
    protected function getTagRepository()
    {
        return $this->get("repository.tag");
    }

    /** @return Repository\CityRepository */
    protected function getCityRepository()
    {
        return $this->get("repository.city");
    }

    /** @return \Knp\Component\Pager\Paginator */
    protected function getPager()
    {
        return $this->get('knp_paginator');
    }
} 
