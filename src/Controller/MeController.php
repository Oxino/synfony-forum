<?php

namespace App\Controller;

use App\Controller\Trait\RoleTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\MeFormType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/me', name: 'me-')]
class MeController extends AbstractController
{
    use  RoleTrait;

    #[Route('/', name: 'main')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(MeFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('me/index.html.twig', [
            'userForm' => $form->createView(),
            'tickets' => $user->getTickets(),
            'answers' => $user->getAnswers(),
        ]);
    }

    #[Route('/close', name: 'close')]
    public function close(EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $user->setClose(true);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('authentication-logout');
    }
}
