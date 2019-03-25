<?php

namespace App\Repository\Profile;

use App\Entity\Profile\DisponibilityPattern;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DisponibilityPattern|null find($id, $lockMode = null, $lockVersion = null)
 * @method DisponibilityPattern|null findOneBy(array $criteria, array $orderBy = null)
 * @method DisponibilityPattern[]    findAll()
 * @method DisponibilityPattern[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DisponibilityPatternRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DisponibilityPattern::class);
    }

    // /**
    //  * @return DisponibilityPattern[] Returns an array of DisponibilityPattern objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DisponibilityPattern
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
