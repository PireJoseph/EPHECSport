<?php

namespace App\Repository\Activity;

use App\Entity\Activity\ActivityInvitation;
use App\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ActivityInvitation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActivityInvitation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActivityInvitation[]    findAll()
 * @method ActivityInvitation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityInvitationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ActivityInvitation::class);
    }

    public function getNonAnsweredForThisUser(User $user)
    {
        $qb = $this->createQueryBuilder('ai');
        $query = $qb
            ->where('ai.recipitent = :user')
            ->setParameter('user', $user)
            ->andWhere('ai.answeredAt is NULL')
            ->getQuery();

        $result = $query->getResult();
        return $result;
    }

    // /**
    //  * @return ActivityInvitation[] Returns an array of ActivityInvitation objects
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
    public function findOneBySomeField($value): ?ActivityInvitation
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
