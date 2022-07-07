<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Ticket;
use App\Form\AnswerType;
use App\Form\TicketFormType;
use App\Repository\TicketRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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

    #[Route('/create', name: 'create')]
    public function createTicket(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketFormType::class, $ticket);
        $form->handleRequest($request);


        if ($this->getUser() && $form->isSubmitted() && $form->isValid()) {
            $author = $this->getUser();
            $ticket->setPublishedDate(new \DateTime('NOW'));
            $ticket->setAuthor($author);
            $ticket->setClose(false);
            $ticket->setSlug($slugger->slug(
                $form['title']->getData()
            )->lower());

            $entityManager->persist($ticket);
            // $entityManager->persist($author);
            $entityManager->flush();
            return $this->redirectToRoute('app_main');
        }
        return $this->render('ticket/create.html.twig', [
            'ticketForm' => $form->createView(),
        ]);
    }

    #[Route('/{slug}', name: 'bySlug')]
    public function ticketBySlug(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
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

    #[Route('/remove/{id}', name: 'removeAnswer')]
    public function ticketRemoveAnswer(Answer $answer, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($answer);
        $entityManager->flush();
        return $this->redirectToRoute('app_main');
    }

    #[Route('/closing/{id}', name: 'close')]
    public function closeTicket(Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $ticket->setClose(true);
        $entityManager->persist($ticket);
        $entityManager->flush();

        return $this->redirectToRoute('app_main');
    }
}
