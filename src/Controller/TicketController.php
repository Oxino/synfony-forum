<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ticket', name: 'ticket-')]
class TicketController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(TicketRepository $ticketRepository): Response
    {
        return $this->render('ticket/index.html.twig', [
            'ticket' => $ticketRepository->findBy(
                [],
                ['published_date' => 'desc'],
            ),
        ]);
    }

    #[Route('/{slug}', name: 'bySlug')]
    public function ticketBySlug(Ticket $ticket): Response {
        return $this->render('ticket/ticket.html.twig', [
            'ticket' => $ticket,
            'answers' => $ticket->getAnswers(),
        ]);
    }
}
