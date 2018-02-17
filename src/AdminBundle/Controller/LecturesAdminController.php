<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\City;
use AppBundle\Entity\Lecture;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AdminBundle\Form;
use Symfony\Component\HttpFoundation\Request;

class LecturesAdminController extends AbstractAdminController
{
    /**
     * @Extra\Route("/lectures/", name="AdminLectures")
     */
    public function lecturesAction(Request $request)
    {
        return $this->manageList($request);
    }

    /**
     * @Extra\Route("/lectures/{id}", name="AdminLecturesByCity")
     */
    public function listByCityAction(Request $request, City $city)
    {
        return $this->manageList(
            $request,
            $this->getLectureRepository()->getQbByCity($city),
            [
                'current_city' => $city,
                'is_list_view' => true,
            ]
        );
    }

    /**
     * @Extra\Route("/lectures/featured/", name="AdminLecturesFeatured")
     * @Extra\Template("admin/featured.html.twig")
     */
    public function lecturesFeaturedAction()
    {
        return [
            'featured_lectures' => $this->get('repository.lecture')->findByIsFeatured(1),
            'unfeatured_lectures' => $this->get('repository.lecture')->findByIsFeatured(0),
        ];
    }

    /**
     * @Extra\Route("/lectures/featured/statistics/", name="AdminLecturesFeaturedStatistics")
     * @Extra\Template("admin/featured-stat.html.twig")
     */
    public function lecturesFeaturedStatisticsAction()
    {
        return [
            'stats' => $this->get('15x4.featured.aggregator')->getStats()
        ];
    }

    /**
     * @Extra\Route("/lectures/{id}/unfeature", name="AdminLectureUnfeature")
     */
    public function unfeatureLectureAction(Lecture $lecture)
    {
        $lecture->setIsFeatured(false);
        $this->getEm()->flush();
        $this->addFlash('success', sprintf('Talk `%s` is no longer featured', $lecture->getTitle()));

        return $this->redirectToRoute('AdminLecturesFeatured');
    }

    /**
     * @Extra\Route("/lectures/{id}/enfeature", name="AdminLectureEnfeature")
     */
    public function enfeatureLectureAction(Lecture $lecture)
    {
        $lecture->setIsFeatured(true);
        $this->getEm()->flush();
        $this->addFlash('success', sprintf('Talk `%s` is now featured', $lecture->getTitle()));

        return $this->redirectToRoute('AdminLecturesFeatured');
    }

    /**
     * @Extra\Route("/lectures/{id}/edit", name="AdminLectureEdit")
     */
    public function editLectureAction(Request $request, Lecture $lecture)
    {
        return $this->manageEdit($request, $lecture);
    }

    /**
     * @Extra\Route("/lectures/{id}/delete", name="AdminLectureDelete")
     */
    public function deleteLectureAction(Lecture $lecture)
    {
        return $this->manageDelete($lecture);
    }

    /** {@inheritdoc} */
    protected function getAdminConfig()
    {
        return [
            'list_route' => 'AdminLectures',
            'list_template' => 'admin/lectures.html.twig',
            'repository_service' => 'repository.lecture',
            'form_type' => Form\LectureType::class,
        ];
    }

    /** @return array */
    protected function getAdditionalListData()
    {
        return [
            'cities' => $this->getCityRepository()->findAllWhichHaveLectures(),
        ];
    }
} 
