<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;

class LandingController extends AbstractController
{
    /**
     * @Extra\Route("/", name="Landing")
     * @Extra\Cache(expires="tomorrow", public=true)
     */
    public function indexAction()
    {
        return $this->render(
            'landing/landing.html.twig',
            [
                'lectures' => $this->getLectureRepository()->findRecent(12),
            ]
        );
    }
}
