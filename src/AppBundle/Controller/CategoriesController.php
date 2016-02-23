<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AppBundle\Entity\City;
use Symfony\Component\HttpFoundation\Request;

class CategoriesController extends AbstractController
{
    /**
     * @Extra\Route("/fields/", name="Fields")
     * @Extra\ParamConverter()
     * @Extra\Cache(expires="tomorrow", public=true)
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
            'tags' => $this->getTagRepository()->findForCloud(),
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
    public function listByCityAction(City $city, Request $request)
    {
        return $this->render('category/events.html.twig', [
            'pagination' => $this->getPager()->paginate(
                $this->getEventRepository()->findForList($city),
                $request->get('page', 1),
                10
            ),
            'city' => $city,
        ]);
    }

    /**
     * @Extra\Route("/lecturers/", name="Lecturers")
     * @Extra\ParamConverter()
     */
    public function lecturersAction(Request $request)
    {
        return $this->render('category/lecturers.html.twig', [
            'pagination' => $this->getPager()->paginate(
                $this->getLecturerRepository()->findForList(),
                $request->get('page', 1),
                20
            ),
        ]);
    }
}
