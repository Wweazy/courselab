<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class LocaleSubscriber implements EventSubscriberInterface
{
    public function __construct(private RequestStack $requestStack) {}

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $session = $this->requestStack->getSession();

        if ($session && $session->has('_locale')) {
            $request->setLocale($session->get('_locale'));
        }
    }
}
