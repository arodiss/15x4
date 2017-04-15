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

        $locale = $this->defaultLocale;
        if ($this->tokenStorage->getToken() && $this->authorizationChecker->isGranted('ROLE_USER')) {
            $locale = $this->tokenStorage->getToken()->getUser()->getLanguage();
        } else {
            foreach ($request->getLanguages() as $browserLanguage) {
                if (substr(strtolower($browserLanguage), 0, 2) === 'en') {
                    $locale = 'en';
                    break;
                }
                if (substr(strtolower($browserLanguage), 0, 2) === 'de') {
                    $locale = 'de';
                    break;
                }
                if (substr(strtolower($browserLanguage), 0, 2) === 'uk') {
                    $locale = 'uk';
                    break;
                }
                if (substr(strtolower($browserLanguage), 0, 2) === 'ru') {
                    $locale = 'ru';
                    break;
                }
            }
        }

        $request->getSession()->set('locale', $locale);
        $request->setLocale($locale);
    }
}
