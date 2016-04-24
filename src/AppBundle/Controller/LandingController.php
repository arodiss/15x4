<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;

class LandingController extends AbstractController
{
    /**
     * @Extra\Route("/", name="Landing")
     */
    public function indexAction()
    {
        //todo enable cache and load registration data asynch
        return $this->render(
            'landing/landing.html.twig',
            [
                'cities' => $this->getCityRepository()->findAll(),
                'featured_lectures' => $this->getLectureRepository()->findFeatured(3),
                'recentEvents' => $this->getEventRepository()->findRecent(4),
            ]
        );
    }

    /**
     * @Extra\Route("/contacts", name="Contacts")
     */
    public function contactsAction()
    {
        return $this->render('contacts.html.twig');
    }

}
