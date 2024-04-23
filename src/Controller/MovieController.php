<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/movie')]
class MovieController extends AbstractController
{
    #[Route('', name: 'app_movie_index')]
    public function index(): Response
    {
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }

    #[Route('/{id<\d+>}', name: 'app_movie_show')]
    public function show(int $id): Response
    {
        $movie = [
            'id' => $id,
            'title' => 'Star Wars - Episode IV : A New Hope',
            'releasedAt' => new \DateTimeImmutable('25-05-1977'),
            'country' => 'United States',
            'plot' => "A young farmer breaks his father's toy weapon.",
            'genres' => ['Action', 'Adventure', 'Fantasy'],
        ];

        return $this->render('movie/show.html.twig', [
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
