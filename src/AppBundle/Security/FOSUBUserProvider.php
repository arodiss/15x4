<?php

namespace AppBundle\Security;

use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as VendorUserProvider;
use AppBundle\Entity\User;
use AppBundle\Entity\Repository\UserRepository;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use Doctrine\ORM\EntityManager;

class FOSUBUserProvider extends VendorUserProvider
{
    /** @var EntityManager */
    private $em;

    /** @var UserRepository */
    private $userRepository;

    /** @param EntityManager $em */
    public function setEm(EntityManager$em)
    {
        $this->em = $em;
    }

    /** @param UserRepository $userRepository */
    public function setUserRepository(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /** {@inheritdoc} */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        try {
            $user = parent::loadUserByOAuthUserResponse($response);
            /** @var User $user */
            $user->updateFromOauthResponse($response);
        } catch (AccountNotLinkedException $e) {
            //persist user on first login
            $user = User::fromOAuthResponse($response);
            //maybe we already know this user from different provider?
            $alreadySignedUser = $this->userRepository->findBy(['email' => $user->getEmail()]);
            if (count($alreadySignedUser)) {
                /** @var User $userTmp */
                $userTmp = $alreadySignedUser[0];
                $userTmp->setPictureUrl($user->getPictureUrl());
                $user = $userTmp;
            }
        }
        $this->em->persist($user);
        $this->em->flush();
        
        return $user;
    }
} 
