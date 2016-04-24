<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AppBundle\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends AbstractController
{
    /**
     * @Extra\Route("/user/me/", name="UserMe")
     */
    public function meAction()
    {
        if ($this->isGranted(['ROLE_USER'])) {
            return new JsonResponse(
                [
                    'logged_in' => true,
                    'picture_url' => $this->getUser()->getPictureUrl(),
                    'displayable_name' => $this->getUser()->getDisplayableName(),
                ]
            );
        } else {
            return new JsonResponse(['logged_in' => false]);
        }
    }
}
