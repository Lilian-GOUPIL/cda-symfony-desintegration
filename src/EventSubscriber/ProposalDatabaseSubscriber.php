<?php

namespace App\EventSubscriber;

use App\Entity\Proposal;
use DateTime;
use DateTimeZone;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpKernel\KernelEvents;

class ProposalDatabaseSubscriber implements EventSubscriberInterface {
    public function getSubscribedEvents(): array {
        return [
            Events::prePersist,
            Events::preUpdate
        ];
    }

    public function prePersist(LifecycleEventArgs $lifecycleEventArgs) {
        $object = $lifecycleEventArgs->getObject();

        if ($object instanceof Proposal) {
            $datetime = new DateTime('now', new DateTimeZone('Europe/Paris'));

            $object->setCreatedAt($datetime);
            $object->setLastUpdatedAt($datetime);
        }
    }

    public function preUpdate(LifecycleEventArgs $lifecycleEventArgs) {
        $object = $lifecycleEventArgs->getObject();

        if ($object instanceof Proposal) {
            $datetime = new DateTime('now', new DateTimeZone('Europe/Paris'));

            $object->setLastUpdatedAt($datetime);
        }
    }
}