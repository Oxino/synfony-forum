<?php

namespace App\Controller;

use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(TicketRepository $ticketRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'ticket' => $ticketRepository->findBy(
                [],
                ['published_date' => 'desc'],
                6,
                0
            ),
        ]);
    }
}
