<?php

namespace App\Repository;

use App\Entity\Exception;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Exception|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exception|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exception[]    findAll()
 * @method Exception[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExceptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exception::class);
    }

    // /**
    //  * @return Exception[] Returns an array of Exception objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Exception
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
