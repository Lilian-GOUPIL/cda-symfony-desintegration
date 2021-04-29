<?php

namespace App\Service;

use App\Entity\Proposal;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class VoteService {
    private $logger;
    private ?User $user;
    private $proposalService;

    public function __construct(TokenStorageInterface $tokenStorage, LoggerInterface $logger, ProposalService $proposalService) {
        $this->logger = $logger;
        $this->user = $tokenStorage->getToken()->getUser() instanceof User ? $tokenStorage->getToken()->getUser() : null;
        $this->proposalService = $proposalService;
    }

    public function addVote($item) {
        $item->addVotedBy($this->user);
        $this->user->addVote($item);

        if ($item instanceof Proposal) {
            $this->logger->info('Vote added successfully');
            return $this->proposalService->update($item);
        }
    }

    public function removeVote($item) {
        $item->removeVotedBy($this->user);
        $this->user->removeVote($item);

        if ($item instanceof Proposal) {
            $this->logger->info('Vote removed successfully');
            return $this->proposalService->update($item);
        }
    }
}