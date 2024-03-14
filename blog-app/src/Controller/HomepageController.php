<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }

    #[Route('/home', name: 'app_homepage_alt', methods: ['GET'])]
    #[Route('/homepage', name: 'app_homepage', methods: ['GET'])]
    public function homepage(): RedirectResponse
    {
        // redirects to the "homepage" route
        return $this->redirectToRoute('app_home');
    }
}
