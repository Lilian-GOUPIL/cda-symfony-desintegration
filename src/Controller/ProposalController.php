<?php

namespace App\Controller;

use App\Entity\Proposal;
use App\Form\ProposalType;
use App\Repository\ProposalRepository;
use App\Services\ProposalService;
use App\Services\VoteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/{_locale}/proposal')]
class ProposalController extends AbstractController
{
    private $proposalService;
    private $voteService;

    public function __construct(ProposalService $proposalService, VoteService $voteService)
    {
        $this->proposalService = $proposalService;
        $this->voteService = $voteService;
    }

    #[Route('/', name: 'proposal_index', methods: ['GET'])]
    /**
     * @Security("is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     */
    public function index(): Response
    {
        return $this->render('proposal/index.html.twig', [
            'proposals' => $this->proposalService->findAll()
        ]);
    }

    #[Route('/new', name: 'proposal_new', methods: ['GET', 'POST'])]
    /**
     * @Security("is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN')")
     */
    public function new(Request $request, SluggerInterface $sluggerInterface): Response
    {
        $proposal = new Proposal();
        $form = $this->createForm(ProposalType::class, $proposal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $image */
            $image = $form->get('image')->getData();

            $proposal->setImage($this->proposalService->saveImage($image));
            $proposal->setProposedBy($this->getUser());

            $this->proposalService->new($proposal);

            return $this->redirectToRoute('proposal_index');
        }

        return $this->render('proposal/new.html.twig', [
            'proposal' => $proposal,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'proposal_show', methods: ['GET'])]
    /**
     * @Security("is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     */
    public function show(Proposal $proposal): Response
    {
        return $this->render('proposal/show.html.twig', [
            'proposal' => $proposal,
        ]);
    }

    #[Route('/{id}/edit', name: 'proposal_edit', methods: ['GET', 'POST'])]
    /**
     * @Security("is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN')")
     */
    public function edit(Request $request, Proposal $proposal): Response
    {
        $oldImage = $proposal->getImage();
        $proposal->setImage(new File($this->getParameter('images_directory') . '/' . $proposal->getImage()));

        if ($proposal->getProposedBy() !== $this->getUser() && !in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('proposal_index');
        }

        $form = $this->createForm(ProposalType::class, $proposal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $image */
            $image = $form->get('image')->getData();

            if ($image) {
                $proposal->setImage($this->proposalService->saveImage($image));
            } else {
                $proposal->setImage($oldImage);
            }

            $this->proposalService->update($proposal);

            return $this->redirectToRoute('proposal_index');
        }

        return $this->render('proposal/edit.html.twig', [
            'proposal' => $proposal,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'proposal_delete', methods: ['POST'])]
    /**
     * @Security("is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN')")
     */
    public function delete(Request $request, Proposal $proposal): Response
    {
        if ($proposal->getProposedBy() !== $this->getUser() && !in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('proposal_index');
        }

        if ($this->isCsrfTokenValid('delete'.$proposal->getId(), $request->request->get('_token'))) {
            $this->proposalService->remove($proposal);
        }

        return $this->redirectToRoute('proposal_index');
    }

    #[Route('/{id}/add_vote', name: 'proposal_add_vote', methods: ['POST'])]
    /**
     * @Security("is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     */
    public function addVote(Request $request, Proposal $proposal): Response {
        if (in_array($proposal, $this->getUser()->getVotes()->getValues())) {
            return $this->redirectToRoute('proposal_index');
        }

        $this->voteService->addVote($proposal);

        if ($request->request->get('source') === 'show') {
            return $this->redirectToRoute('proposal_show', ['id' => $proposal->getId()]);
        } else {
            return $this->redirectToRoute('proposal_index');
        }
    }

    #[Route('/{id}/remove_vote', name: 'proposal_remove_vote', methods: ['POST'])]
    /**
     * @Security("is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     */
    public function removeVote(Request $request, Proposal $proposal): Response {
        if (in_array($proposal, $this->getUser()->getVotes()->getValues())) {
            $this->voteService->removeVote($proposal);
        }

        if ($request->request->get('source') === 'show') {
            return $this->redirectToRoute('proposal_show', ['id' => $proposal->getId()]);
        } else {
            return $this->redirectToRoute('proposal_index');
        }
    }
}
