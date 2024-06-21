<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category', methods: ['GET', 'POST'])]
    public function index(CategoryRepository $categoryRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $categoryRepository->createQueryBuilder('c'), /* query NOT result */
            $request->query->get('page') ?? 1, /*page number*/
            10 /*limit per page*/
        );

        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'pagination' => $pagination,
        ]);
    }

    #[Route('/category/{id<^\d+$>}/show/', name: 'app_category_show', methods: ['GET', 'POST'])]
    public function show(Category $category): Response
    {
        //$category = $categoryRepository->find($id);

        return $this->render('category/show.html.twig', [
            'controller_name' => 'CategoryController Show',
            'category' => $category,
        ]);
    }

    #[Route('/category/add', name: 'app_category_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($form->getData());

            $em->flush();

            return $this->redirectToRoute('app_category');
        }

        return $this->render('category/add.html.twig', [
            'controller_name' => 'CategoryController Add',
            'form' => $form,
        ]);
    }

    #[Route('/category/{id<^\d+$>}/edit', name: 'app_category_edit', methods: ['GET', 'POST'])]
    public function edit(Category $category, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($form->getData());

            $em->flush();

            return $this->redirectToRoute('app_category');
        }

        return $this->render('category/add.html.twig', [
            'controller_name' => 'CategoryController Edit',
            'form' => $form,
        ]);
    }
}
