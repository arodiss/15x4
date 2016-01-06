<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Repository\EventRepository;
use AppBundle\Entity\Repository\FieldRepository;
use AppBundle\Entity\City;

class CategoriesController extends Controller
{
    //todo paging and ordering

    /**
     * @Extra\Route("/fields/", name="Fields")
     * @Extra\ParamConverter()
     */
    public function fieldsAction()
    {
        return $this->render('category/fields.html.twig', [
            "fields" => $this->getFieldRepository()->findWithTags(),
        ]);
    }

    /**
     * @Extra\Route("/tags/", name="Tags")
     * @Extra\ParamConverter()
     */
    public function tagsAction()
    {
        return $this->render('category/tags.html.twig', [
            "tags" => $this->get("repository.tag")->findAll(),
        ]);
    }

    /**
     * @Extra\Route("/cities/", name="Cities")
     * @Extra\ParamConverter()
     */
    public function citiesAction()
    {
        return $this->render('category/cities.html.twig', [
            "cities" => $this->get("repository.city")->findAll(),
        ]);
    }

    /**
     * @Extra\Route("/lecture/city/{id}", name="LectureByCity")
     * @Extra\ParamConverter()
     */
    public function listByCityAction(City $city)
    {
        return $this->render('category/by-city.html.twig', [
            "events" => $this->getEventRepository()->findByCity($city),
            "city" => $city,
        ]);
    }

    /**
     * @Extra\Route("/lecturers/", name="Lecturers")
     * @Extra\ParamConverter()
     */
    public function lecturersAction()
    {
        return $this->render('category/by-lecturer.html.twig', [
            "lecturers" => $this->get("repository.lecturer")->findAll(),
        ]);
    }

    /** @return EventRepository */
    protected function getEventRepository()
    {
        return $this->get("repository.event");
    }

    /** @return FieldRepository */
    protected function getFieldRepository()
    {
        return $this->get("repository.field");
    }
}
