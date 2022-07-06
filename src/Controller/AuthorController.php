<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/author', name: 'author-')]
class AuthorController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('author/index.html.twig', [
            'authors' => $userRepository->findAll()
        ]);
    }

    #[Route('/{id<\d+>}', name: 'byId')]
    public function authorById(User $user): Response
    {
        return $this->render('author/author.html.twig', [
            'user' => $user,
            'tickets' => $user->getTickets(),
            'answers' => $user->getAnswers(),
        ]);
    }

    #[Route('/{slug}', name: 'bySlug')]
    public function authorSlug(User $user): Response
    {
        return $this->render('author/author.html.twig', [
            'user' => $user,
            'tickets' => $user->getTickets(),
            'answers' => $user->getAnswers(),
        ]);
    }
}
