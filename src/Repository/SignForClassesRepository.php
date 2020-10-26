<?php

namespace App\Repository;

use App\Entity\SignForClasses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SignForClasses|null find($id, $lockMode = null, $lockVersion = null)
 * @method SignForClasses|null findOneBy(array $criteria, array $orderBy = null)
 * @method SignForClasses[]    findAll()
 * @method SignForClasses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SignForClassesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SignForClasses::class);
    }

    // /**
    //  * @return SignForClasses[] Returns an array of SignForClasses objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('z')
            ->andWhere('z.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('z.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SignForClasses
    {
        return $this->createQueryBuilder('z')
            ->andWhere('z.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
