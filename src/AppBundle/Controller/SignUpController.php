<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AppBundle\Entity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SignUpController extends AbstractController
{
    /**
     * @Extra\Route("/sign-up/{id}/conditions/", name="GetSignUpConditions")
     * @Extra\ParamConverter()
     */
    public function getSignUpConditionsAction(Entity\Announcement $announcement)
    {
        return new JsonResponse([
            'registerable' => $announcement->isRegisterable(),
            'tickets_left' => $announcement->hasFreeTickets(),
        ]);
    }

    /**
     * @Extra\Route("/sign-up/{id}", name="SignUpForEvent")
     * @Extra\ParamConverter()
     */
    public function signUpAction(Entity\Announcement $announcement, Request $request)
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
