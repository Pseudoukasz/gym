<?php

namespace App\Repository;

use App\Entity\Trener;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trener|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trener|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trener[]    findAll()
 * @method Trener[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrenerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trener::class);
    }

    // /**
    //  * @return Trener[] Returns an array of Trener objects
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
    public function findOneBySomeField($value): ?Trener
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
