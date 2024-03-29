<?php

namespace App\Controller\Anonymous;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/post')]
class PostController extends AbstractController
{
    #[Route('/', name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('user/post/index.html.twig', [
            'posts' => $postRepository->findBy(['published' => true]),
        ]);
    }

    #[Route('/{slug}', name: 'app_post_by_slug', methods: ['GET'])]
    public function showBySlug(PostRepository $postRepository, string $slug): Response
    {
        $post = $postRepository->findOneBy(['slug' => $slug, 'published' => true]);

        if (null != $post) {
            return $this->render('user/post/show.html.twig', [
                'post' => $post
            ]);
        } else {
            $this->redirectToRoute('app_post_index');
        }    
    }
}
