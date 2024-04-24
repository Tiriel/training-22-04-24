<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/movie')]
class MovieController extends AbstractController
{
    #[Route('', name: 'app_movie_index')]
    public function index(MovieRepository $repository): Response
    {
        return $this->render('movie/index.html.twig', [
            'movies' => $repository->findAll(),
        ]);
    }

    #[Route('/{id<\d+>}', name: 'app_movie_show')]
    public function show(int $id, MovieRepository $repository): Response
    {
        $movie = $repository->find($id);

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/new', name: 'app_movie_new', methods: ['GET', 'POST'])]
    #[Route('/{id<\d+>}/edit', name: 'app_movie_edit', methods: ['GET', 'POST'])]
    public function newMovie(?Movie $movie): Response
    {
        $movie ??= new Movie();
        $form = $this->createForm(MovieType::class, $movie);

        return $this->render('movie/new.html.twig', [
            'form' => $form,
            'movie' => $movie,
        ]);
    }

    #[Route('/_decades', name: 'app_movie_decades')]
    public function decades(): Response
    {
        $decades = ['80', '90', '2000'];

        return $this->render('includes/_decades.html.twig', [
            'decades' => $decades
        ]);
    }
}
