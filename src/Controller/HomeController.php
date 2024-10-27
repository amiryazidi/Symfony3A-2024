<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/home')]
 class HomeController extends AbstractController {

    #[Route('/msg1', name: 'app_home')]
    public function index() {

       // return new Response('Hello World');
       return $this -> render('home/index.html.twig', [
           'controller_name' => 'HomeController',
       ]);
    }

    #[Route('/msg2', name: 'msg2')]
    public function show() {
        $userName = 'Amir';
        return $this->render('home/test.html.twig', [
            'n' => $userName,
        ]);
    }
    
    #[Route('/msg3', name: 'msg3')]
    public function msg() {
        $user =array(array('name' => 'Amir', 'age' => 25, 'image' => 'https://www.w3schools.com/w3images/avatar2.png'),
        array('name' => 'ahmed', 'age' => 22, 'image' => 'https://www.w3schools.com/w3images/avatar2.png'),
        array('name' => 'yasmine', 'age' => 23, 'image' => 'https://www.w3schools.com/w3images/avatar2.png'),) ;
        return $this -> render('home/tabl.html.twig', [
           'user' => $user,
       ]);
    }

    #[Route('/details/{id}', name: 'd')]     
    
    public function details($id): Response 
    {         return new Response('users'.$id); 
    } 

 }

?>