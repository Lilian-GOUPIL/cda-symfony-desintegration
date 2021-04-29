<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

class PasswordChangeSubscriber implements EventSubscriberInterface
{
    private $security;
    private $urlGenerator;

    public function __construct(Security $security, UrlGeneratorInterface $urlGenerator) {
        $this->security = $security;
        $this->urlGenerator = $urlGenerator;
    }

    public static function getSubscribedEvents(): array {
        return [
            KernelEvents::REQUEST => [
                'forcePasswordChange'
            ],
        ];
    }

    public function forcePasswordChange(RequestEvent $event): void {
        // Only deal with the main request, disregard subrequests.
        if (!$event->isMasterRequest()) {
            return;
        }

        $user = $this->security->getUser();
        
        // If it is not a valid user, it means it's not an authenticated request, moving on.
        if (!$user instanceof User) {
            return;            
        }

        // If it is not their first login, and they do not need to change their password, moving on.
        if (!$user->getForcePasswordChange()) {
            return;
        }

        // If we get here, it means we need to redirect them to the password change view.
        $redirectTo = $this->urlGenerator->generate('account_index');

        // If the URL the user is trying to access is different than the URL of the change password page, redirecting to the change password page.
        if ($event->getRequest()->getRequestUri() != $redirectTo){
            $event->setResponse(new RedirectResponse($redirectTo));
        }

        return;
    }
}