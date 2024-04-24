<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/{id<\d+>}', name: 'app_book_show', methods: ['GET'])]
    public function show(int $id, BookRepository $repository): Response
    {
        $book = $repository->find($id);

        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/new', name: 'app_book_new_book', methods: ['GET', 'POST'])]
    public function newBook(EntityManagerInterface $manager): Response
    {
        $book = (new Book())
            ->setTitle('1984')
            ->setCover('https://blablah.com')
            ->setAuthor('G.Orwell')
            ->setReleasedAt(new \DateTimeImmutable('01-01-1959'))
            ->setPlot('This book is too real')
            ->setIsbn('913-12345678-12');

        $manager->persist($book);
        $manager->flush();

        return $this->render('book/new.html.twig');
    }
}
