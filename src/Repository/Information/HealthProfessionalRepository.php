<?php

namespace App\Repository\Information;

use App\Entity\Information\HealthProfessional;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method HealthProfessional|null find($id, $lockMode = null, $lockVersion = null)
 * @method HealthProfessional|null findOneBy(array $criteria, array $orderBy = null)
 * @method HealthProfessional[]    findAll()
 * @method HealthProfessional[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HealthProfessionalRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, HealthProfessional::class);
    }

    // /**
    //  * @return HealthProfessional[] Returns an array of HealthProfessional objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HealthProfessional
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
