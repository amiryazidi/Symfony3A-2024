<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    #[Route('/', name: 'app_crud_book')]
    public function index(BookRepository $repository,AuthorRepository $authorRep, Request $request): Response
    {   $authorName=$request->get('authorName');
        if($authorName==''){
            $books=$repository->findAll();
        }else{
            //search author by AuthorName
              $author=$authorRep->findOneBy(['name'=>$authorName]);
            //books by author Name
            //repositoryBook => findByAuthor
            $books=$repository->findByAuthor($author);
            if(count($books)==0){
                return  new Response('No books found');
            }
        }
        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/new', name:'app_new_book')]
  public function newBook(Request $request,ManagerRegistry $doctrine):Response
    {  //1. instance Book
        $book= new Book();
        //2.create interface form
        $form=$this->createForm(BookType::class,$book);
        //handle data from
        $form=$form->handleRequest($request);

        //..validation data
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$doctrine->getManager();
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('app_crud_book');
        }

        return $this->render('book/form.html.twig',
        ['form'=>$form->createView()]);
    }


    #[Route('/edit/{id}', name:'app_editbook')]
    public function editBook(Request $request,ManagerRegistry $doctrine,Book $book):Response
    {

        //2.create interface form
        $form=$this->createForm(BookType::class,$book);
        //handle data from
        $form=$form->handleRequest($request);

        //..validation data
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_crud_book');
        }

        return $this->render('book/form.html.twig',
            ['form'=>$form->createView()]);
    }

}
