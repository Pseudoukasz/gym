<?php

namespace App\Repository;

use App\Entity\Zajecia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Zajecia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Zajecia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Zajecia[]    findAll()
 * @method Zajecia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZajeciaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Zajecia::class);
    }

    // /**
    //  * @return Zajecia[] Returns an array of Zajecia objects
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
    public function findOneBySomeField($value): ?Zajecia
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
