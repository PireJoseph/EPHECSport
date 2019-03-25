<?php

namespace App\Repository\Activity;

use App\Entity\Activity\ActivityParticipation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ActivityParticipation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActivityParticipation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActivityParticipation[]    findAll()
 * @method ActivityParticipation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityParticipationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ActivityParticipation::class);
    }

    // /**
    //  * @return ActivityParticipation[] Returns an array of ActivityParticipation objects
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
    public function findOneBySomeField($value): ?ActivityParticipation
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
