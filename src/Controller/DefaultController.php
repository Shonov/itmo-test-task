<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/books", name="books")
     */
    public function books(): Response
    {
        return $this->render('book/list.html.twig', [
            'books' => $this->getDoctrine()->getRepository(Book::class)->findAll(),
        ]);
    }


    /**
     * @Route("/authors", name="authors")
     */
    public function authors(): Response
    {
        return $this->render('author/list.html.twig', [
            'authors' => $this->getDoctrine()->getRepository(Author::class)->findAll(),
        ]);
    }
}
