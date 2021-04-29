<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#[Route('/{_locale}/account')]
/**
 * @Security("is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
 */
class AccountController extends AbstractController
{
    private $userPasswordEncoderInterface;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
        $this->userPasswordEncoderInterface = $userPasswordEncoderInterface;
    }

    #[Route('/', name: 'account_index', methods: ['GET', 'POST'])]
    public function index(Request $request): ?Response
    {
        $user = $this->getUser();

        if ($request->request->get('password') !== null) {
            $user->setPassword($this->userPasswordEncoderInterface->encodePassword($user, $request->request->get('password')));
            $user->setForcePasswordChange(false);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('root');
        }

        return $this->render('account/index.html.twig');
    }
}
