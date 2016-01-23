<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AboutController extends Controller
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
            ]
        );
    }
}
