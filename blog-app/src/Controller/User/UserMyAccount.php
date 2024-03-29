<?php

namespace App\Controller\User;

use App\Form\User\UserAccountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile/my-account')]
class UserMyAccount extends AbstractController
{
    #[Route('/', name: 'app_user_my_account', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('user/account/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    #[Route('/edit', name: 'app_user_my_account_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserAccountType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToMyAccount();
        }

        return $this->render('user/account/edit.html.twig', [
            'user' => $this->getUser(),
            'form' => $form
        ]);
    }

    private function redirectToMyAccount($status = Response::HTTP_SEE_OTHER) {
        return $this->redirectToRoute('app_user_my_account', [], $status);
    }
}
