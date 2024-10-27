<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/author')]
class AuthorController extends AbstractController
{

    private $authors;

    public function __construct()
    {
        $this->authors = [
            ['id' => 1, 'picture' => '/images/Victor-Hugo.jpg', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com', 'nb_books' => 100],
            ['id' => 2, 'picture' => '/images/william-shakespeare.jpg', 'username' => 'William Shakespeare', 'email' => 'william.shakespeare@gmail.com', 'nb_books' => 200],
            ['id' => 3, 'picture' => '/images/Taha_Hussein.jpg', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300],
        ];
    }

    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/show/{name}', name: 'show')]
    public function showAuthor($name): Response
    {
        return $this->render('author/show.html.twig', [
            'n' => $name,
        ]);
    }
    
    #[Route('/list', name: 'list')]
    public function listAuthor(): Response
    {
    
        return $this->render('author/list.html.twig', [
            'authors' => $this->authors,
        ]);
    }


    #[Route('/author/details/{id}', name: 'author_details')]
public function authorDetails(int $id): Response
{
    // Récupérer l'auteur en fonction de l'ID
    $author  = $this->authors[$id] ?? null;
    return $this->render('author/detail.html.twig', [
        'author' => $author,
    ]);
}
}