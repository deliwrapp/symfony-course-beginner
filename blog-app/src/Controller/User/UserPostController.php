<?php

namespace App\Controller\User;

use App\Entity\Post;
use App\Form\User\UserPostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile/my-post')]
class UserPostController extends AbstractController
{
    #[Route('/', name: 'app_user_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('user/post/index.html.twig', [
            'posts' => $postRepository->findBy(['author' => $this->getUser()])
        ]);
    }

    #[Route('/new', name: 'app_user_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $post->setAuthor($this->getUser());
        $form = $this->createForm(UserPostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToIndex();
        }

        return $this->render('user/post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_user_post_by_slug', methods: ['GET'])]
    public function showBySlug(PostRepository $postRepository, string $slug): Response
    {
        $post = $postRepository->findOneBy(['slug' => $slug]);
        if ($post->getAuthor() == $this->getUser()) {
            return $this->render('user/post/show.html.twig', [
                'post' => $post,
            ]);
        } elseif ($post->isPublished()) {
            return $this->redirectToRoute('app_post_by_slug', ['slug' => $post->getSlug()]);
        } else {
            return $this->redirectToIndex(Response::HTTP_UNAUTHORIZED);
        }
        
    }

    #[Route('/{id}/edit', name: 'app_user_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($post->getAuthor() == $this->getUser()) {
            $form = $this->createForm(UserPostType::class, $post);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();
                return $this->redirectToIndex();
            }

            return $this->render('user/post/edit.html.twig', [
                'post' => $post,
                'form' => $form,
            ]);
        } else {
            return $this->redirectToIndex(Response::HTTP_UNAUTHORIZED);
        } 
    }

    #[Route('/{id}', name: 'app_user_post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($post->getAuthor() == $this->getUser()) {
            if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
                $entityManager->remove($post);
                $entityManager->flush();
                return $this->redirectToIndex();
            }
            return $this->redirectToRoute('app_user_post_edit', ['id' => $post->getId()]);
        }
        return $this->redirectToIndex(Response::HTTP_UNAUTHORIZED);
    }

    private function redirectToIndex($status = Response::HTTP_SEE_OTHER) {
        return $this->redirectToRoute('app_user_post_index', [], $status);
    }
}
