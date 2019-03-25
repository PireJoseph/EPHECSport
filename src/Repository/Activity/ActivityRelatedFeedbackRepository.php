<?php

namespace App\Repository\Activity;

use App\Entity\Activity\ActivityRelatedFeedback;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ActivityRelatedFeedback|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActivityRelatedFeedback|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActivityRelatedFeedback[]    findAll()
 * @method ActivityRelatedFeedback[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityRelatedFeedbackRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ActivityRelatedFeedback::class);
    }

    // /**
    //  * @return ActivityRelatedFeedback[] Returns an array of ActivityRelatedFeedback objects
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
    public function findOneBySomeField($value): ?ActivityRelatedFeedback
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
