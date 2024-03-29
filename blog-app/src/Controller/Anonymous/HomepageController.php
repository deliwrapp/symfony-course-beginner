<?php

namespace App\Controller\Anonymous;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PostRepository;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('anonymous/homepage/index.html.twig', [
            'posts' => $postRepository->findBy(['published' => true]),
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
