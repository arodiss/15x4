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
        $featured = $this->getLectureRepository()->findFeatured(3);

        return $this->render(
            'landing/landing.html.twig',
            [
                'cities' => $this->getCityRepository()->findAll(),
                'featured_lectures' => $featured,
                'lectures' => $this->getLectureRepository()->findRecent(9, $featured),
            ]
        );
    }
}
