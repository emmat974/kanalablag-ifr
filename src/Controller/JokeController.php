<?php

namespace App\Controller;

use App\Entity\Joke;
use App\Form\JokeType;
use App\Repository\JokeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/joke')]
class JokeController extends AbstractController
{
    #[Route('/', name: 'app_joke_index', methods: ['GET'])]
    public function index(JokeRepository $jokeRepository): Response
    {
        return $this->render('joke/index.html.twig', [
            'jokes' => $jokeRepository->findBy(['user' => $this->getUser()]),
        ]);
    }


    #[IsGranted('ROLE_ADMIN')]
    #[Route('/moderate', name: 'app_joke_moderate', methods: ['GET'])]
    public function moderate(JokeRepository $jokeRepository): Response
    {
        return $this->render('joke/moderate.html.twig', [
            'jokes' => $jokeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_joke_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $joke = new Joke();
        $joke->setUser($this->getUser());
        $form = $this->createForm(JokeType::class, $joke);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($joke);
            $entityManager->flush();

            return $this->redirectToRoute('app_joke_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('joke/new.html.twig', [
            'joke' => $joke,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_joke_show', methods: ['GET'])]
    public function show(Joke $joke): Response
    {
        return $this->render('joke/show.html.twig', [
            'joke' => $joke,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_joke_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Joke $joke, EntityManagerInterface $entityManager): Response
    {
        if ($joke->getUser() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(JokeType::class, $joke);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_joke_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('joke/edit.html.twig', [
            'joke' => $joke,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_joke_delete', methods: ['POST'])]
    public function delete(Request $request, Joke $joke, EntityManagerInterface $entityManager): Response
    {
        if ($joke->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_home');
        }

        if ($this->isCsrfTokenValid('delete' . $joke->getId(), $request->request->get('_token'))) {
            $entityManager->remove($joke);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_joke_index', [], Response::HTTP_SEE_OTHER);
    }
}
