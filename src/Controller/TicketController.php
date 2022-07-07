<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Ticket;
use App\Form\AnswerType;
use App\Repository\TicketRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function ticketBySlug(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response {
        $answer = new Answer();
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($this->getUser() && $form->isSubmitted() && $form->isValid()) {
            $author = $this->getUser();
            $answer->setPublishedDate(new \DateTimeImmutable());
            $answer->setAuthor($author);
           
            $answer->setTicket($ticket);

            $entityManager->persist($answer);
            $entityManager->flush();
        }

        $criteria = Criteria::create()
            ->orderBy(["created_at" => 'desc']);
        return $this->render('ticket/ticket.html.twig', [
            'ticket' => $ticket,
            'answerForm' => $form->createView(),
            'answers' => $ticket->getAnswers()->matching($criteria),
        ]);
    }
}
