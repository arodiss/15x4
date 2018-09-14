<?php

namespace AppBundle\Controller;

use AppBundle\Entity\City;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp;

class LandingController extends AbstractController
{
    const MUNICH_ID = 14;

    /**
     * @Extra\Route("/", name="Landing")
     */
    public function indexAction()
    {
        return $this->render(
            'landing/landing.html.twig',
            [
                'cities' => $this->getCityRepository()->findForLanding(),
                'featured_lectures' => $this->getLectureRepository()->findFeatured(3),
                'recent_lectures' => $this->getLectureRepository()->findRecent(15),
                'tags' => $this->getTagRepository()->findForCloud(4),
            ]
        );
    }

    /**
     * @Extra\Route("/bg/{id}", name="Background")
     */
    public function bgAction(City $city)
    {
        return $this->render('landing/bg.html.twig', ['city' => $city]);
    }

    /**
     * @Extra\Route("/particles", name="Particles")
     */
    public function particlesAction()
    {
        return $this->render('landing/particles.html.twig');
    }

    /**
     * @Extra\Route("/contacts", name="Contacts")
     */
    public function contactsAction()
    {
        $contacts = $this->getContactRepository()->findAll();
        shuffle($contacts);
        return $this->render(
            'contacts/contacts.html.twig',
            [
                'contacts' => $contacts,
                'cities' => $this->getCityRepository()->findAllWithContacts(),
            ]
        );
    }

    /**
     * @Extra\Route("/landing/munich", name="LandingMunich")
     */
    public function munichAction()
    {
        //should be moved to event subscriber if there would be more custom landings
        $this->forceMainDomain();
        $munich = $this->getCityRepository()->find(self::MUNICH_ID);

        return $this->render(
            'landing/munich.html.twig',
            [
                'munich' => $munich,
                'featured_lectures' => $this->getLectureRepository()->findFeaturedMunich(3),
            ]
        );
    }

    /**
     * @Extra\Route("/{id}/live", name="Live")
     * @Extra\Template
     */
    public function liveAction(City $city)
    {
        $cityFbId = $city->getFbLink();
        if (false == $cityFbId) {
            return $this->redirectToRoute('Landing');
        }

        $client = new GuzzleHttp\Client();
        $rawResponse = $client->request(
            'GET',
            sprintf(
                'https://graph.facebook.com/oauth/access_token?client_id=%s&client_secret=%s&grant_type=client_credentials',
                $this->container->getParameter('facebook_id'),
                $this->container->getParameter('facebook_secret')
            )
        )->getBody();
        $response = json_decode($rawResponse, true);
        if (false == isset($response['access_token'])) {
            $this->getLogger()->critical('Failed to get FB access token. The response is ' . $rawResponse);
            return $this->redirectToRoute('Landing');
        }

        $token = $response['access_token'];
        $rawResponse = $client->request(
            'GET',
            sprintf(
                'https://graph.facebook.com/v2.10/%s/videos?access_token=%s',
                $cityFbId,
                $token
            )
        )->getBody();
        $response = json_decode($rawResponse, true);
        if (
            false == isset($response['data'])
            || false == isset($response['data'][0])
            || false == isset($response['data'][0]['id'])

        ) {
            $this->getLogger()->critical(
                'Something wrong with page\'s video list, cannot get last video. The response is ' . $rawResponse
            );
            return $this->redirectToRoute('Landing');
        }


        $videoId = $response['data'][0]['id'];
        return $this->render(
            'landing/live.html.twig',
            [
                'city' => $city,
                'videoId' => $videoId
            ]
        );
    }
}
