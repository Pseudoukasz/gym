<?php

namespace App\Repository;

use App\Entity\Trainers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trainers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trainers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trainers[]    findAll()
 * @method Trainers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trainers::class);
    }

    // /**
    //  * @return Trainers[] Returns an array of Trainers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Trainers
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
