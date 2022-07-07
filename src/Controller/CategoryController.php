<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CategoryFormType;

#[Route('/category', name: 'category-')]
class CategoryController extends AbstractController 
{
    #[Route('/', name: 'main')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll()
        ]);
    }
    
    #[Route('/{id<\d+>}', name: 'byId')]
    public function categoryById(Category $category): Response {
        return $this->render('category/category.html.twig', [
            'category' => $category,
            'tickets' => $category->getTickets(),
        ]);
    }

    #[Route('/{slug}', name: 'bySlug')]
    public function categoryBySlug(Category $category): Response {
        return $this->render('category/category.html.twig', [
            'category' => $category,
            'tickets' => $category->getTickets(),
        ]);
    }

    #[Route('/edit/{slug}', name: 'editBySlug')]
    public function edit(Category $category, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'categoryForm' => $form->createView(),
        ]);
    }
}
