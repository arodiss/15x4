<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Component\HttpFoundation\Request;

class LandingController extends AbstractController
{
    const MUNICH_ID = 14;

    /**
     * @Extra\Route("/", name="Landing")
     */
    public function indexAction()
    {
        return $this->render(
            'landing/landing.html.twig',
            [
                'cities' => $this->getCityRepository()->findForLanding(),
                'featured_lectures' => $this->getLectureRepository()->findFeatured(3),
                'recent_lectures' => $this->getLectureRepository()->findRecent(15),
                'tags' => $this->getTagRepository()->findForCloud(5),
            ]
        );
    }

    /**
     * @Extra\Route("/bg", name="Background")
     */
    public function bgAction()
    {
        return $this->render('landing/bg.html.twig');
    }

    /**
     * @Extra\Route("/contacts", name="Contacts")
     */
    public function contactsAction()
    {
        return $this->render('contacts/contacts.html.twig');
    }

    /**
     * @Extra\Route("/landing/munich", name="LandingMunich")
     */
    public function munichAction()
    {
        //should be moved to event subscriber if there would be more custom landings
        $this->forceMainDomain();
        $munich = $this->getCityRepository()->find(self::MUNICH_ID);

        return $this->render(
            'landing/munich.html.twig',
            [
                'next_announcement' => $munich->getNextAnnouncement(),
                'past_announcement' => $munich->getLastAnnouncement(),
                'munich_event_ids' => $munich->getEventIds(),
                'featured_lectures' => $this->getLectureRepository()->findFeatured(3),
            ]
        );
    }
}
