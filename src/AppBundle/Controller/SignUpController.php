<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AppBundle\Entity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SignUpController extends AbstractController
{
    /**
     * @Extra\Route("/sign-up/{id}", name="SignUpForEvent")
     * @Extra\ParamConverter()
     */
    public function reactAction(Entity\Announcement $announcement, Request $request)
    {
        $announcement->addTicketsBooking(
            $request->get('name'),
            $request->get('count')
        );
        if ($request->get('contact')) {
            $announcement->addVolunteer(
                $request->get('name'),
                $request->get('contact')
            );
        }
        $this->getEm()->flush();

        return new Response();
    }
} 
