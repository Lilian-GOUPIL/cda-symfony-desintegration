<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserDatabaseSubscriber implements EventSubscriberInterface {
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder) {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function getSubscribedEvents(): array {
        return [
            Events::prePersist
        ];
    }

    public function prePersist(LifecycleEventArgs $lifecycleEventArgs) {
        $object = $lifecycleEventArgs->getObject();

        if ($object instanceof User) {
            $object->setPassword($this->userPasswordEncoder->encodePassword($object, $object->getUsername()));
            $object->setForcePasswordChange(true);
        }
    }
}