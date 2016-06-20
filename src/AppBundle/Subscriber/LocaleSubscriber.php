<?php

namespace AppBundle\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class LocaleSubscriber implements EventSubscriberInterface
{
    /** @var TokenStorageInterface */
    private $tokenStorage;

    /** @var AuthorizationCheckerInterface */
    private $authorizationChecker;

    /** @var string */
    private $defaultLocale;

    /**
     * @param TokenStorageInterface $tokenStorage
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @param $defaultLocale
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        AuthorizationCheckerInterface $authorizationChecker,
        $defaultLocale
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
        $this->defaultLocale = $defaultLocale;
    }

    /** {@inheritdoc} */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [['setLocale', 11]]
        ];
    }

    /** @param GetResponseEvent $event */
    public function setLocale(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if ($request->attributes->get('_route') === 'SetLanguage') {
            return;
        }
        if (false === $request->hasPreviousSession() && false == $this->tokenStorage->getToken()) {
            return;
        }
        if ($this->tokenStorage->getToken() && $this->authorizationChecker->isGranted('ROLE_USER')) {
            $request->getSession()->set('locale', $this->tokenStorage->getToken()->getUser()->getLanguage());
        }
        $request->setLocale($request->getSession()->get('locale', $this->defaultLocale));
    }
}
