<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $userPasswordEncoderInterface;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
        $this->userPasswordEncoderInterface = $userPasswordEncoderInterface;
    }

    public function load(ObjectManager $manager)
    {
        $aurelien = new User();
        $aurelien->setUsername('adelorme')
            ->setPassword($this->userPasswordEncoderInterface->encodePassword($aurelien, $aurelien->getUsername()))
            ->setForcePasswordChange(true)
            ->setRoles(['ROLE_SUPER_ADMIN', 'ROLE_ADMIN'])
            ->setFirstName('Aurélien')
            ->setLastName('Delorme');

        $rodolphe = new User();
        $rodolphe->setUsername('rbossin')
            ->setPassword($this->userPasswordEncoderInterface->encodePassword($rodolphe, $rodolphe->getUsername()))
            ->setForcePasswordChange(true)
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName('Rodolphe')
            ->setLastName('Bossin');

        $manon = new User();
        $manon->setUsername('mcayrolles')
            ->setPassword($this->userPasswordEncoderInterface->encodePassword($manon, $manon->getUsername()))
            ->setForcePasswordChange(true)
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName('Manon')
            ->setLastName('Cayrolles');

        $elhadji = new User();
        $elhadji->setUsername('echanfi')
            ->setPassword($this->userPasswordEncoderInterface->encodePassword($elhadji, $elhadji->getUsername()))
            ->setForcePasswordChange(true)
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName('Elhadji')
            ->setLastName('Chanfi');

        $augustin = new User();
        $augustin->setUsername('acharly')
            ->setPassword($this->userPasswordEncoderInterface->encodePassword($augustin, $augustin->getUsername()))
            ->setForcePasswordChange(true)
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName('Augustin')
            ->setLastName('Charly');

        $serge = new User();
        $serge->setUsername('scomont')
            ->setPassword($this->userPasswordEncoderInterface->encodePassword($serge, $serge->getUsername()))
            ->setForcePasswordChange(true)
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName('Serge')
            ->setLastName('Comont');

        $alexandre = new User();
        $alexandre->setUsername('afayolle')
            ->setPassword($this->userPasswordEncoderInterface->encodePassword($alexandre, $alexandre->getUsername()))
            ->setForcePasswordChange(true)
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName('Alexandre')
            ->setLastName('Fayolle');

        $remy = new User();
        $remy->setUsername('rgot')
            ->setPassword($this->userPasswordEncoderInterface->encodePassword($remy, $remy->getUsername()))
            ->setForcePasswordChange(true)
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName('Rémy')
            ->setLastName('Got');

        $lilian = new User();
        $lilian->setUsername('lgoupil')
            ->setPassword($this->userPasswordEncoderInterface->encodePassword($lilian, $lilian->getUsername()))
            ->setForcePasswordChange(true)
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName('Lilian')
            ->setLastName('Goupil');

        $mickael = new User();
        $mickael->setUsername('mjacquot')
            ->setPassword($this->userPasswordEncoderInterface->encodePassword($mickael, $mickael->getUsername()))
            ->setForcePasswordChange(true)
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName('Mickael')
            ->setLastName('Jacquot');

        $anthony = new User();
        $anthony->setUsername('amartins')
            ->setPassword($this->userPasswordEncoderInterface->encodePassword($anthony, $anthony->getUsername()))
            ->setForcePasswordChange(true)
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName('Anthony')
            ->setLastName('Martins');

        $nathan = new User();
        $nathan->setUsername('nmoresco')
            ->setPassword($this->userPasswordEncoderInterface->encodePassword($nathan, $nathan->getUsername()))
            ->setForcePasswordChange(true)
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName('Nathan')
            ->setLastName('Moresco');

        $johan = new User();
        $johan->setUsername('jrispal')
            ->setPassword($this->userPasswordEncoderInterface->encodePassword($johan, $johan->getUsername()))
            ->setForcePasswordChange(true)
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName('Johan')
            ->setLastName('Rispal');

        $manager->persist($aurelien);
        $manager->persist($rodolphe);
        $manager->persist($manon);
        $manager->persist($elhadji);
        $manager->persist($augustin);
        $manager->persist($serge);
        $manager->persist($alexandre);
        $manager->persist($remy);
        $manager->persist($lilian);
        $manager->persist($mickael);
        $manager->persist($anthony);
        $manager->persist($nathan);
        $manager->persist($johan);

        $manager->flush();
    }
}
