<?php

namespace App\Repository;

use App\Entity\Peronne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Peronne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Peronne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Peronne[]    findAll()
 * @method Peronne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PeronneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Peronne::class);
    }

    // /**
    //  * @return Peronne[] Returns an array of Peronne objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Peronne
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
