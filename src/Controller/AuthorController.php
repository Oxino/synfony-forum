<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/author', name: 'author-')]
class AuthorController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(UserRepository $userRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('authentication-login');
        }
        if (!in_array('ROLE_ADMINISTRATOR', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('app_main');
        }
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

    #[Route('/banish/{id}', name: 'banish')]
    public function banishAuthor(User $user, EntityManagerInterface $entityManager): Response
    {
        if (!$user->isBanned()) {
            $user->setBanned(true);
        } else {
            $user->setBanned(false);
        }
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('author-main');
    }
}
