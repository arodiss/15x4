<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AppBundle\Entity;
use AppBundle\Entity\Repository\LectureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LectureController extends Controller
{
    //todo - paging and ordering for lists

    /**
     * @Extra\Route("/lecture/discussion/{id}/", name="LectureDetails")
     * @Extra\ParamConverter()
     */
    public function detailsAction(Entity\Lecture $lecture)
    {
        return $this->render('lecture/details.html.twig', [
            "lecture" => $lecture,
        ]);
    }

    /**
     * @Extra\Route("/lecture/all/", name="LectureAll")
     */
    public function listAllAction()
    {
        return $this->render('lecture/all.html.twig', [
            "lectures" => $this->getLectureRepository()->findAll(),
        ]);
    }

    /**
     * @Extra\Route("/lecture/filtered/", name="LectureFiltered")
     */
    public function listFilteredAction()
    {
        //todo: real implementation
        return $this->render('lecture/all.html.twig', [
            "lectures" => $this->getLectureRepository()->findAll(),
        ]);
    }

    /**
     * @Extra\Route("/lecture/event/{id}", name="LectureByEvent")
     * @Extra\ParamConverter()
     */
    public function listByEventAction(Entity\Event $event)
    {
        return $this->render('lecture/by-event.html.twig', [
            "lectures" => $this->getLectureRepository()->findByEvent($event),
            "event" => $event,
        ]);
    }

    /**
     * @Extra\Route("/lecture/lecturer/{id}", name="LectureByLecturer")
     * @Extra\ParamConverter()
     */
    public function listByLecturerAction(Entity\Lecturer $lecturer)
    {
        return $this->render('lecture/by-lecturer.html.twig', [
            "lectures" => $this->getLectureRepository()->findByLecturer($lecturer),
            "lecturer" => $lecturer,
        ]);
    }

    /**
     * @Extra\Route("/lecture/field/{id}", name="LectureByField")
     * @Extra\ParamConverter()
     */
    public function listByFieldAction(Entity\Field $field)
    {
        return $this->render('lecture/by-field.html.twig', [
            "lectures" => $this->getLectureRepository()->findByField($field),
            "field" => $field,
        ]);
    }

    /**
     * @Extra\Route("/lecture/tag/{id}", name="LectureByTag")
     * @Extra\ParamConverter()
     */
    public function listByTagAction(Entity\Tag $tag)
    {
        return $this->render('lecture/by-tag.html.twig', [
            "lectures" => $this->getLectureRepository()->findByTag($tag),
            "tag" => $tag,
        ]);
    }

    /** @return LectureRepository */
    protected function getLectureRepository()
    {
        return $this->get("repository.lecture");
    }
}
