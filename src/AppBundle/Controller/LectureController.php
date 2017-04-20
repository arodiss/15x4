<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AppBundle\Entity;
use Symfony\Component\HttpFoundation\Request;

class LectureController extends AbstractController
{
    /**
     * @Extra\Route("/lecture/discussion/{id}/", name="LectureDetailsLong")
     */
    public function detailsOldAction(Request $request)
    {
        return $this->redirectToRoute('LectureDetails', ['id' => $request->get('id')]);
    }

    /**
     * @Extra\Route("/L/{id}/", name="LectureDetails")
     * @Extra\Route("/l/{id}/", name="LectureDetailsAlt")
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
     * @Extra\Route("/lectures/", name="LectureList")
     */
    public function listAllAction(Request $request)
    {
        $tagIds = explode(',', $request->get('tags', ''));
        $eventIds = explode(',', $request->get('events', ''));
        $fieldIds = explode(',', $request->get('fields', ''));
        $lecturerIds = explode(',', $request->get('lecturers', ''));
        $languages = array_filter(explode(',', $request->get('langs', '')));

        $tags = $this->getTagRepository()->findByIds($tagIds);
        $events = $this->getEventRepository()->findByIds($eventIds);
        $fields = $this->getFieldRepository()->findByIds($fieldIds);
        $lecturers = $this->getLecturerRepository()->findByIds($lecturerIds);

        return $this->render(
            'lecture/list.html.twig',
            [
                'pagination' => $this->getPager()->paginate(
                    $this->getLectureRepository()->findByFilters($fields, $tags, $events, $lecturers, $languages),
                    $request->get('page', 1),
                    40
                ),
                'isFiltered' => $tags || $events || $fields || $lecturers,
                'selectedTags' => $tags,
                'availableTags' => $this->getTagRepository()->findForFilter($tagIds),
                'selectedEvents' => $events,
                'availableEvents' => $this->getEventRepository()->findForFilter($eventIds),
                'selectedFields' => $fields,
                'availableFields' => $this->getFieldRepository()->findForFilter($fieldIds),
                'selectedLecturers' => $lecturers,
                'availableLecturers' => $this->getLecturerRepository()->findForFilter($lecturerIds),
                'selectedLangs' => $languages
            ]
        );
    }

    /**
     * @Extra\Route("/lectures/featured/", name="LectureListFeatured")
     */
    public function listFeaturedAction(Request $request)
    {
        return $this->render(
            'lecture/featured.html.twig',
            [
                'pagination' => $this->getPager()->paginate(
                    $this
                        ->getLectureRepository()
                        ->createQueryBuilder('l')
                        ->andWhere('l.isFeatured = 1')
                        ->leftJoin('l.event', 'e')
                        ->orderBy('e.date', 'desc'),
                    $request->get('page', 1),
                    30
                ),
            ]
        );
    }

    /**
     * @Extra\Route("/lecture/field/{id}", name="LectureByField")
     * @Extra\ParamConverter()
     */
    public function listByFieldAction(Entity\Field $field, Request $request)
    {
        return $this->render('lecture/by-field.html.twig', [
            'pagination' => $this->getPager()->paginate(
                $this->getLectureRepository()->findByFilters([ $field ]),
                $request->get('page', 1),
                10
            ),
            'tags' => $this->getFieldRepository()->findWithTags($field)[0]['tags'],
            'field' => $field,
        ]);
    }

    /**
     * @Extra\Route("/lectures/favorite", name="MyFavoriteLectures")
     */
    public function myFavoritesAction(Request $request)
    {
        if (false == $this->getUser()) {
            return $this->redirectToRoute('LectureList');
        }

        return $this->render(
            'lecture/favorites.html.twig',
            [
                'pagination' => $this->getPager()->paginate(
                    $this->getLectureRepository()->findByIds($this->getUser()->getFavoriteLectureIds()),
                    $request->get('page', 1),
                    10
                ),
            ]
        );
    }
}
