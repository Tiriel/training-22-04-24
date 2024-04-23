<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'app_book_index', methods: ['GET'])]
    #[Template('book/index.html.twig')]
    public function index(): array
    {
        return [
            'controller_name' => 'BookController::index',
        ];
    }

    #[Route('/{id<\d+>?0}', name: 'app_book_show', methods: ['GET'])]
    public function show(Request $request, ?int $id = 1): Response
    {
        //dump(
        //    $request->attributes->get('_route'),
        //    $request->attributes->get('_controller'),
        //    $request->attributes->get('_route_params'),
        //    $request->attributes->get('id'),
        //);

        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController::show - id: '. $id,
        ]);
    }
}
