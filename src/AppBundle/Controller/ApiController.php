<?php

namespace AppBundle\Controller;

use AppBundle\Entity\City;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends AbstractController
{
    /**
     * @Extra\Route("/api/upcoming", name="ApiUpcomingEvents")
     */
    public function upcomingEventsAction()
    {
        $upcomingEvents = [];
        foreach ($this->getCityRepository()->findAll() as $city) {
            /** @var City $city */
            if ($city->hasValidAnnouncement()) {
                $announcement = $city->getNextAnnouncement();
                $lectures = [];
                foreach ($announcement->getLectures() as $lecture) {
                    $lectures[] = [
                        'title' => $lecture->getTitle(),
                        'teaser' => $lecture->getTeaser(),
                        'lecturer' => [
                            'id' => $lecture->getLecturer()->getId(),
                            'name' => $lecture->getLecturer()->getName(),
                            'bio' => $lecture->getLecturer()->getBio(),
                        ]
                    ];
                }

                $upcomingEvents[] = [
                    'city' => $city->getName(),
                    'time' => $announcement->getWhen(),
                    'address' => $announcement->getWhere(),
                    'mapAddress' => $announcement->getWhereMap(),
                    'lectures' => $lectures,
                ];
            }
        }

        return new JsonResponse(['events' => $upcomingEvents ]);
    }
}
