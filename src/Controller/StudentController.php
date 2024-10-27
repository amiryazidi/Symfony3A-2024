<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\ClassroomRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/student')]
class StudentController extends AbstractController
{
    #[Route('/st', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
    #[Route('/fetch', name: 'fetch')]
    public function fetch(StudentRepository $repo): Response
    {
        $result = $repo->findAll();
        return $this->render('student/dql.html.twig', [
            'result' => $result,
        ]);
    }

    #[Route('/fetch2', name: 'fetch2')]
    public function fetch2(ManagerRegistry $mr): Response
    {
        $repo = $mr->getRepository(Student::class);
        $result = $repo->findAll();
        return $this->render('student/list.html.twig', [
            'students' => $result,
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(ManagerRegistry $mr, ClassroomRepository $repo, Request $req): Response
    {
        $s = new Student();  // instance de l'objet student

        $form = $this->createForm(StudentType::class, $s);  // creation du formulaire
        $form->handleRequest($req);  // recuperation des données du formulaire
        if ($form->isSubmitted()) {
            // Persister les données
            $em = $mr->getManager();
            $em->persist($s);
            $em->flush();
            return $this->redirectToRoute('fetch');
        }
        return $this->render('student/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/remove/{id}', name: 'remove')]
    public function remove(ManagerRegistry $mr, $id, StudentRepository $repo)
    {
        $student = $repo->find($id);
        $em = $mr->getManager();
        $em->remove($student);
        $em->flush();
        return $this->redirectToRoute('fetch');
    }

    #[Route('/update/{id}', name: 'update')]
    public function update(ManagerRegistry $mr, $id, StudentRepository $repo)
    {
        $student = $repo->find($id);
        $student->setName('socho');
        $em = $mr->getManager();
        $em->persist($student);
        $em->flush();
        return $this->redirectToRoute('fetch');
    }

    #[Route('/dql', name: 'dql')]
    public function dql(EntityManagerInterface $em, Request $request, StudentRepository $repo): Response
    {
        $result = $repo->findAll();
        $req = $em->createQuery("select s from App\Entity\Student s where s.name=:n");
        if ($request->isMethod('POST')) {
            // 2. Créer une Requête DQL avec createQuery    
            $value = $request->get('test');
            $req->setParameter('n', $value);
            // 3. Récupérer les résultats
            $result = $req->getResult();
        }
        //dd($result);
        return $this->render('student/dql.html.twig', [
            'result' => $result,
        ]);
    }

    #[Route('/dql2', name: 'dql2')]
    public function dql2( Request $request, StudentRepository $repo): Response
    {
        $result = $repo->findAll();
        if ($request->isMethod('POST')) {
            $value = $request->get('test');
            $result = $repo->fetchStudentsByName($value);
        }
        return $this->render('student/dql.html.twig', [
            'result' => $result,
        ]);
    }

    #[Route('/dql3', name: 'dql3')]
    public function dql3(EntityManagerInterface $em)
    {
        $req= $em->createQuery('select s.name from App\Entity\Student s Order By s.name ASC');
        $result=$req->getResult();
        //dd($result[0][1]);
        dd($result);  
    }
    #[Route('/dqlJoin', name: 'dqlJoin')]
    public function dqlJoin(StudentRepository $repo){
        $result= $repo->fetchAffectedStudents();
        dd($result);
    }
 //Query Builder
    #[Route('/qb', name: 'dqlJoin')]
    public function qb(StudentRepository $repo){
        $result= $repo->fetchAffectedStudentsQB();
        dd($result);
    }
}
