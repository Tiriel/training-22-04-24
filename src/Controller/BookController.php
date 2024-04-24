<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'app_book_index', methods: ['GET'])]
    public function index(BookRepository $repository): Response
    {
        $books = $repository->findAll();

        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/{id<\d+>}', name: 'app_book_show', methods: ['GET'])]
    public function show(int $id, BookRepository $repository): Response
    {
        $book = $repository->find($id);

        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/new', name: 'app_book_new', methods: ['GET', 'POST'])]
    #[Route('/{id<\d+>}', name: 'app_book_edit', methods: ['GET', 'POST'])]
    public function newBook(?Book $book, Request $request, BookRepository $repository): Response
    {
        $book ??= new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($book, true);

            return $this->redirectToRoute('app_book_show', ['id' => $book->getId()]);
        }

        return $this->render('book/new.html.twig', [
            'form' => $form,
        ]);
    }
}
