<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Joke;
use App\Repository\CategoryRepository;
use App\Repository\JokeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        CategoryRepository $categoryRepository,
        EntityManagerInterface $em,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        $dql = "SELECT j FROM App\Entity\Joke j ORDER BY j.updatedAt DESC";
        $query = $em->createQuery($dql);

        $paginator = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );


        return $this->render('home/index.html.twig', [
            'categories' => $categoryRepository->findall(),
            'jokes' => $paginator
        ]);
    }

    #[Route('/categories/{id}', name: 'app_home_categories')]
    public function category(
        Category $category,
        EntityManagerInterface $em,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        $dql = "SELECT j FROM App\Entity\Joke j JOIN j.category c WHERE c.id = :categoryId ORDER BY j.updatedAt DESC";
        $query = $em->createQuery($dql);
        $query->setParameter('categoryId', $category->getId());

        $paginator = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('home/categories.html.twig', [
            'category' => $category,
            'jokes' => $paginator
        ]);
    }

    #[Route("/blague/{id}", name: 'app_home_joke')]
    public function blague(Joke $joke): Response
    {
        return $this->render('home/joke.html.twig', [
            'joke' => $joke
        ]);
    }
}
