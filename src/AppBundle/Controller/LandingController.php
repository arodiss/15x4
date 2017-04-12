<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Component\HttpFoundation\Request;

class LandingController extends AbstractController
{
    /**
     * @Extra\Route("/", name="Landing")
     */
    public function indexAction(Request $request)
    {
        return $this->render(
            'landing/landing.html.twig',
            [
                'cities' => $this->getCityRepository()->findForLanding(),
                'featured_lectures' => $this->getLectureRepository()->findFeatured(3),
                'recent_lectures' => $this->getLectureRepository()->findRecent(16),
            ]
        );
    }

    /**
     * @Extra\Route("/contacts", name="Contacts")
     */
    public function contactsAction()
    {
        return $this->render('contacts/contacts.html.twig');
    }
}
