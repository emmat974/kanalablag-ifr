<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\JokeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        CategoryRepository $categoryRepository,
        JokeRepository $jokeRepository
    ): Response {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'categories' => $categoryRepository->findall(),
            'jokes' => $jokeRepository->findAll()
        ]);
    }

    #[Route('/categories/{id}', name: 'app_home_joke')]
    public function category(
        Category $category
    ): Response {
        return $this->render('home/categories.html.twig', [
            'controller_name' => 'HomeController',
            'category' => $category,
            'jokes' => $category->getJokes()
        ]);
    }
}
