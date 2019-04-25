<?php

namespace App\Repository\Activity;

use App\Entity\Activity\UserRelatedFeedback;
use App\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserRelatedFeedback|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserRelatedFeedback|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserRelatedFeedback[]    findAll()
 * @method UserRelatedFeedback[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRelatedFeedbackRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserRelatedFeedback::class);
    }

    public function getAggregatedUserFeedbackCount(User $user)
    {
        $qb = $this->createQueryBuilder('u');
        return $qb
            ->select('count(u.label) as count, u.label')
            ->andWhere('u.user = :user')
            ->setParameter('user', $user)
            ->groupBy('u.label')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return UserRelatedFeedback[] Returns an array of UserRelatedFeedback objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserRelatedFeedback
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
