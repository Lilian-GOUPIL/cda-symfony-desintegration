<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class ExceptionService {
    private $logger;
    private $entityManager;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager) {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    public function new($exception) {
        $this->entityManager->persist($exception);
        $this->entityManager->flush();

        $this->logger->info('Request added successfully');
        return $exception;
    }
}