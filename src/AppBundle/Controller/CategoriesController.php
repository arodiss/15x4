<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AppBundle\Entity\City;

class CategoriesController extends AbstractController
{
    //todo paging

    /**
     * @Extra\Route("/fields/", name="Fields")
     * @Extra\ParamConverter()
     */
    public function fieldsAction()
    {
        return $this->render('category/fields.html.twig', [
            'fields' => $this->getFieldRepository()->findWithTags(),
        ]);
    }

    /**
     * @Extra\Route("/tags/", name="Tags")
     * @Extra\ParamConverter()
     */
    public function tagsAction()
    {
        return $this->render('category/tags.html.twig', [
            'tags' => $this->getTagRepository()->findForList(),
        ]);
    }

    /**
     * @Extra\Route("/cities/", name="Cities")
     * @Extra\ParamConverter()
     */
    public function citiesAction()
    {
        return $this->render('category/cities.html.twig', [
            'cities' => $this->getCityRepository()->findForList(),
        ]);
    }

    /**
     * @Extra\Route("/lecture/city/{id}", name="EventByCity")
     * @Extra\ParamConverter()
     */
    public function listByCityAction(City $city)
    {
        return $this->render('category/events.html.twig', [
            'events' => $this->getEventRepository()->findForList($city),
            'city' => $city,
        ]);
    }

    /**
     * @Extra\Route("/lecturers/", name="Lecturers")
     * @Extra\ParamConverter()
     */
    public function lecturersAction()
    {
        return $this->render('category/lecturers.html.twig', [
            'lecturers' => $this->getLecturerRepository()->findForList(),
        ]);
    }
}
