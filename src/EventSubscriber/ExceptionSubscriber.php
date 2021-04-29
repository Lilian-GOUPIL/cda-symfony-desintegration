<?php

namespace App\EventSubscriber;

use App\Entity\Exception;
use App\Service\ExceptionService;
use DateTime;
use DateTimeZone;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface {
    private $exceptionService;

    public function __construct(ExceptionService $exceptionService) {
        $this->exceptionService = $exceptionService;
    }

    public static function getSubscribedEvents(): array {
        return [
            KernelEvents::EXCEPTION => [
                'saveException'
            ],
        ];
    }

    public function saveException(ExceptionEvent $event) {
        if ($event->getThrowable() instanceof HttpException) {
            // This line may be shown to have an error in VSCode, this is due to the Intelephense extension.
            $exception = new Exception($event->getRequest()->getRequestUri(), $event->getRequest()->getMethod(), $event->getThrowable()->getStatusCode(), $event->getThrowable()->getMessage(), $event->getThrowable()->getTraceAsString(), new DateTime('now', new DateTimeZone('Europe/Paris')));
        } else {
            $exception = new Exception($event->getRequest()->getRequestUri(), $event->getRequest()->getMethod(), null, $event->getThrowable()->getMessage(), $event->getThrowable()->getTraceAsString(), new DateTime('now', new DateTimeZone('Europe/Paris')));
        }

        $this->exceptionService->new($exception);
    }
}