<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Extra\Route("/", name="AdminIndex")
     */
    public function indexAction()
    {
        return $this->render('admin/index.html.twig');
    }
} 
