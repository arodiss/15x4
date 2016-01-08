<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AppBundle\Entity;
use Symfony\Component\HttpFoundation\Request;

class LectureController extends AbstractController
{
    //todo paging

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
     * @Extra\Route("/lecture/random/", name="LectureRandom")
     */
    public function randomAction()
    {
        return $this->render('lecture/details.html.twig', [
            'lecture' => $this->getLectureRepository()->getRandom(),
        ]);
    }

    /**
     * @Extra\Route("/lecture/all/", name="LectureAll")
     */
    public function listAllAction()
    {
        return $this->render('lecture/all.html.twig', [
            'lectures' => $this->getLectureRepository()->findByFilters(),
        ]);
    }

    /**
     * @Extra\Route("/lecture/filtered/", name="LectureFiltered")
     */
    public function listFilteredAction(Request $request)
    {
        $tag = $request->get('tag') ? $this->getTagRepository()->find($request->get('tag')) : null;
        $event = $request->get('event') ? $this->getEventRepository()->find($request->get('event')) : null;
        $field = $request->get('field') ? $this->getFieldRepository()->find($request->get('field')) : null;
        $lecturer = $request->get('lecturer') ? $this->getLecturerRepository()->find($request->get('lecturer')) : null;
        if (!$tag && !$event &&!$field && !$lecturer) {
            return $this->redirectToRoute('LectureAll');
        }

        return $this->render(
            'lecture/filtered.html.twig',
            [
                'lectures' => $this->getLectureRepository()->findByFilters($tag, $event, $field, $lecturer),
                'tag' => $tag,
                'event' => $event,
                'field' => $field,
                'lecturer' => $lecturer,
            ]
        );
    }

    /**
     * @Extra\Route("/lecture/field/{id}", name="LectureByField")
     * @Extra\ParamConverter()
     */
    public function listByFieldAction(Entity\Field $field)
    {
        return $this->render('lecture/by-field.html.twig', [
            'lectures' => $this->getLectureRepository()->findByField($field),
            'tags' => $this->getFieldRepository()->findWithTags($field)[0]['tags'],
            'field' => $field,
        ]);
    }
}
