<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService {
    private $logger;
    private $entityManager;
    private UserRepository $userRepository;
    private $userPasswordEncoder;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder) {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
        $this->userRepository = $this->entityManager->getRepository(User::class);
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function findAll() {
        return $this->userRepository->findAll();
    }

    public function findOne($id) {
        return $this->userRepository->find($id);
    }

    public function findOneBy($criteria) {
        return $this->userRepository->findOneBy($criteria);
    }

    public function new($user) {   
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->logger->info('User added successfully');
        return $user;
    }

    public function update($user) {
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->logger->info('User updated successfully');
        return $user;
    }

    public function resetPassword($user) {
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, $user->getUsername()));
        $user->setForcePasswordChange(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->logger->info('User\'s password successfully reset');
        return $user;
    }

    public function remove($user) {
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        $this->logger->info('User removed successfully');
        return $user;
    }
}