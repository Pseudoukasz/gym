<?php

namespace App\Repository;

use App\Entity\ZapisyNaZajecia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ZapisyNaZajecia|null find($id, $lockMode = null, $lockVersion = null)
 * @method ZapisyNaZajecia|null findOneBy(array $criteria, array $orderBy = null)
 * @method ZapisyNaZajecia[]    findAll()
 * @method ZapisyNaZajecia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZapisyNaZajeciaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ZapisyNaZajecia::class);
    }

    // /**
    //  * @return ZapisyNaZajecia[] Returns an array of ZapisyNaZajecia objects
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
    public function findOneBySomeField($value): ?ZapisyNaZajecia
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
