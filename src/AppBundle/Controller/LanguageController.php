<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Component\HttpFoundation\Request;

class LanguageController extends AbstractController
{
    /**
     * @Extra\Route("/set-lang/{lang}", name="SetLanguage")
     */
    public function indexAction(Request $request)
    {
        $request->getSession()->set('locale', $request->get('lang'));
        if ($this->isGranted('ROLE_USER')) {
            $this->getUser()->setLanguage($request->get('lang'));
            $this->getEm()->persist($this->getUser());
            $this->getEm()->flush();
        }
        if ($request->headers->has('referer')) {
            return $this->redirect($request->headers->get('referer'));
        }
        return $this->redirectToRoute('Landing');
    }
}
