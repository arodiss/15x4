<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;

class LandingController extends AbstractController
{
    /**
     * @Extra\Route("/", name="Landing")
     * @Extra\Cache(expires="+5minutes", public=true)
     */
    public function indexAction()
    {
        return $this->render(
            'landing/landing.html.twig',
            [
                'cities' => $this->getCityRepository()->findAll(),
                'featured_lectures' => $this->getLectureRepository()->findFeatured(4),
                'lectures' => $this->getLectureRepository()->findRecent(12),
            ]
        );
    }
}
