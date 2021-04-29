<?php

namespace App\EventSubscriber;

use App\Entity\Request;
use App\Service\RequestService;
use DateTime;
use DateTimeZone;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestSubscriber implements EventSubscriberInterface {
    private $requestService;

    public function __construct(RequestService $requestService) {
        $this->requestService = $requestService;
    }

    public static function getSubscribedEvents(): array {
        return [
            KernelEvents::REQUEST => [
                'saveRequest'
            ],
        ];
    }

    public function saveRequest(RequestEvent $event) {
        $request = new Request($event->getRequest()->getRequestUri(), $event->getRequest()->getMethod(), new DateTime('now', new DateTimeZone('Europe/Paris')));
        $this->requestService->new($request);
    }
}