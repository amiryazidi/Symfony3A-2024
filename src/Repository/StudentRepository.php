<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    //    /**
    //     * @return Student[] Returns an array of Student objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Student
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    //dql
    public function fetchStudentsByName($name)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT s FROM App\Entity\Student s WHERE s.name = :name');
        $query->setParameter('name', $name);
        return $query->getSQL();
    }

    public function fetchAffectedStudents()
    {
        $em = $this->getEntityManager();
        $req=$em->createQuery("select s.name t, c.name from App\Entity\Student s join  s.classroom c where c.name='3A41'");
        $result=$req->getResult();
        return $result;
    }

 //Query Builder
    public function fetchAffectedStudentsQB()
    {
        $qb = $this->createQueryBuilder('s')
            ->select('s.name', 'c.name')
            ->join('s.classroom', 'c')
            ->where("c.name = '3A65'");
       

        $preresult = $qb->getQuery();
        $result = $preresult->getResult();
        return $result;
    }
}
