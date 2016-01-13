<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LandingController extends Controller
{
    /**
     * @Extra\Route("/", name="Landing")
     */
    public function indexAction()
    {
        return $this->render('landing/landing.html.twig');
    }
}
