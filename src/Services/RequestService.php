<?php

namespace App\Services;

use App\Entity\Request;
use App\Repository\RequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class RequestService {
    private $logger;
    private $entityManager;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager) {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    public function new($request) {  
        $this->entityManager->persist($request);
        $this->entityManager->flush();

        $this->logger->info('Request added successfully');
        return $request;
    }
}