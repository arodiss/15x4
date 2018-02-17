<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Extra\Route("/", name="AdminIndex")
     */
    public function indexAction()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Extra\Route("/i18n-update", name="AdminTranslationsUpdate")
     */
    public function updateTranslationsAction(Request $request)
    {
        $this->get('15x4.i18n_updater')->update();
        $this->addFlash('success', 'Translations updated');

        if ($request->headers->has('referer')) {
            return $this->redirect($request->headers->get('referer'));
        }
        return $this->redirectToRoute('AdminIndex');
    }
} 
