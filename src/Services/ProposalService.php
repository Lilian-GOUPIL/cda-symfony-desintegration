<?php

namespace App\Services;

use App\Entity\Proposal;
use App\Repository\ProposalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProposalService {
    private $logger;
    private $entityManager;
    private ProposalRepository $proposalRepository;
    private $parameters;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager, ParameterBagInterface $parameters) {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
        $this->proposalRepository = $this->entityManager->getRepository(Proposal::class);
        $this->parameters = $parameters;
    }

    public function findAll() {
        return $this->proposalRepository->findAll();
    }

    public function findOne($id) {
        return $this->proposalRepository->find($id);
    }

    public function new($proposal) {
        $this->entityManager->persist($proposal);
        $this->entityManager->flush();

        $this->logger->info('Proposal added successfully');
        return $proposal;
    }

    public function update($proposal) {
        $this->entityManager->persist($proposal);
        $this->entityManager->flush();

        $this->logger->info('Proposal updated successfully');
        return $proposal;
    }

    public function remove($proposal) {
        $this->entityManager->remove($proposal);
        $this->entityManager->flush();

        $this->logger->info('Proposal removed successfully');
        return $proposal;
    }

    public function saveImage($image) {
        $imageName = uniqid() . '.' . $image->guessExtension();

        try {
            $image->move($this->parameters->get('images_directory'), $imageName);
        } catch (FileException $e) {
            throw new FormError('An error occured during the upload of the image');
        }

        return $imageName;
    }

    public function findWinner() {
        return $this->proposalRepository->findWinner();
    }
}