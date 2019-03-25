<?php

namespace App\Repository\Activity;

use App\Entity\Activity\ActivityCancellation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ActivityCancellation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActivityCancellation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActivityCancellation[]    findAll()
 * @method ActivityCancellation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityCancellationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ActivityCancellation::class);
    }

    // /**
    //  * @return ActivityCancellation[] Returns an array of ActivityCancellation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ActivityCancellation
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
