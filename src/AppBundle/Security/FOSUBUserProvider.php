<?php

namespace AppBundle\Security;

use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as VendorUserProvider;
use AppBundle\Entity\User;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use Doctrine\ORM\EntityManager;

class FOSUBUserProvider extends VendorUserProvider
{
    /** @var EntityManager */
    private $em;

    /** @param EntityManager $em */
    public function setEm(EntityManager$em)
    {
        $this->em = $em;
    }

    /** {@inheritdoc} */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        try {
            return parent::loadUserByOAuthUserResponse($response);
        } catch (AccountNotLinkedException $e) {
            //persist user on first login
            $user = User::fromOAuthResponse($response);
            $this->em->persist($user);
            $this->em->flush();

            return $user;
        }
    }
} 
