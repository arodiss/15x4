<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AppBundle\Form\SignUpType;
use AppBundle\Entity;
use Symfony\Component\HttpFoundation\Request;

class SignUpController extends AbstractController
{
    /**
     * @Extra\Route("/sign-up/{id}", name="SignUpForEvent")
     * @Extra\ParamConverter()
     * @Extra\Template("sign-up.html.twig")
     */
    public function signUpAction(Entity\Announcement $announcement, Request $request)
    {
        $form = $this->createForm(SignUpType::class, ['announcement' => $announcement]);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $announcement->addTicketsBooking(
                $data['name'],
                $data['extra'] + 1
            );
            if ($data['contact']) {
                $announcement->addVolunteer(
                    $data['name'],
                    $data['contact']
                );
            }
            $this->getEm()->flush();
            $this->addFlash(
                'success',
                $this->getTranslator()->trans("Спасибо за регистрацию! Ждём вас в лектории")
            );

            return $this->redirectToRoute('Landing');
        }

        return [
            'form' => $form->createView(),
            'event' => $announcement,
        ];
    }
} 
