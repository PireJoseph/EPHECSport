<?php

namespace App\Repository\Activity;

use App\Entity\Activity\ActivityJoiningRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ActivityJoiningRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActivityJoiningRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActivityJoiningRequest[]    findAll()
 * @method ActivityJoiningRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityJoiningRequestRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ActivityJoiningRequest::class);
    }

    // /**
    //  * @return ActivityJoiningRequest[] Returns an array of ActivityJoiningRequest objects
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
    public function findOneBySomeField($value): ?ActivityJoiningRequest
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
