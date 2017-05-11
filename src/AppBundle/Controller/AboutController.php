<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;

class AboutController extends AbstractController
{
    /**
     * @Extra\Route("/about", name="About")
     */
    public function indexAction()
    {
        return $this->render(
            'about/about.html.twig',
            [
                'ignoreContainer' => true,
                'cities' => $this->getCityRepository()->findAll()
            ]
        );
    }
}
