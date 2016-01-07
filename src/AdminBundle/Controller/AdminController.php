<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AdminBundle\Form;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    //todo paging

    //todo better inputs for long lists

    /**
     * @Extra\Route("/", name="AdminIndex")
     */
    public function indexAction()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Extra\Route("/lectures/", name="AdminLectures")
     */
    public function lecturesAction(Request $request)
    {
        return $this->admin(
            $request,
            Form\LectureType::class,
            'AdminLectures',
            'admin/lectures.html.twig',
            'repository.lecture'
        );
    }

    /**
     * @Extra\Route("/lecturers/", name="AdminLecturers")
     */
    public function lecturersAction(Request $request)
    {
        return $this->admin(
            $request,
            Form\LecturerType::class,
            'AdminLecturers',
            'admin/lecturers.html.twig',
            'repository.lecturer'
        );
    }

    /**
     * @Extra\Route("/events/", name="AdminEvents")
     */
    public function eventsAction(Request $request)
    {
        return $this->admin(
            $request,
            Form\EventType::class,
            'AdminEvents',
            'admin/events.html.twig',
            'repository.event'
        );
    }

    /**
     * @Extra\Route("/tags/", name="AdminTags")
     */
    public function tagsAction(Request $request)
    {
        return $this->admin(
            $request,
            Form\TagType::class,
            'AdminTags',
            'admin/tags.html.twig',
            'repository.tag'
        );
    }

    /**
     * @Extra\Route("/cities/", name="AdminCities")
     */
    public function citiesAction(Request $request)
    {
        return $this->admin(
            $request,
            Form\CityType::class,
            'AdminCities',
            'admin/cities.html.twig',
            'repository.city'
        );
    }

    /**
     * @param Request $request
     * @param $formType
     * @param $route
     * @param $template
     * @param $repositoryServiceName
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function admin(Request $request, $formType, $route, $template, $repositoryServiceName)
    {
        if ($request->isMethod('POST')) {
            $form = $this->createForm($formType)->handleRequest($request);
            if ($form->isValid()) {
                $this->getEm()->persist($form->getData());
                $this->getEm()->flush();

                return $this->redirectToRoute($route);
            }
        }

        return $this->render(
            $template,
            [
                'entities' => $this->get($repositoryServiceName)->findAll(),
                'form' => $this->createForm($formType)->createView()
            ]
        );
    }

    /** @return EntityManager */
    protected function getEm()
    {
        return $this->get("doctrine.orm.entity_manager");
    }
} 
