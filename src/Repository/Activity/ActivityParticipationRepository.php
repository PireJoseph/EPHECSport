<?php

namespace App\Repository\Activity;

use App\Entity\Activity\Activity;
use App\Entity\Activity\ActivityParticipation;
use App\Entity\User\User;
use DateTime;
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

    public function getPastsForUser(User $user)
    {
        $now = new DateTime();

        $query =  $this->createQueryBuilder('ap')
            ->join('ap.activity', 'a')
            ->where('a.startAt < :now')
            ->setParameter('now', $now)
            ->andWhere('ap.user = :user')
            ->setParameter('user', $user)

            ->orderBy('a.startAt', 'ASC')
            ->addOrderBy('a.endAt', 'ASC')
            ->getQuery();

        $result = $query->getResult();

        return $result;
    }

    public function getNextsForUser(User $user)
    {

        $now = new DateTime();
        $query =  $this->createQueryBuilder('ap')
            ->join('ap.activity', 'a')
            ->where('a.startAt > :now')
            ->setParameter('now', $now)
            ->andWhere('ap.user = :user')
            ->setParameter('user', $user)

            ->orderBy('a.startAt', 'ASC')
            ->addOrderBy('a.endAt', 'ASC')
            ->getQuery();

        $result = $query->getResult();

        return $result;

    }

    public function getNextsForUserWithRelatedCancellation(User $user)
    {
        $now = new DateTime();

        $query =  $this->createQueryBuilder('ap')
            ->join('ap.activity', 'a')
            ->leftjoin('App\Entity\Activity\ActivityCancellation', 'ac', 'WITH', 'ac.activity = ap.activity')

            ->select('ap')
            ->addSelect(' ac')

            ->where('a.startAt > :now')
            ->setParameter('now', $now)
            ->andWhere('ap.user = :user')
            ->setParameter('user', $user)

            ->orderBy('a.startAt', 'ASC')
            ->addOrderBy('a.endAt', 'ASC')
            ->getQuery();

        $result = $query->getResult();

        return $result;

    }

    public function getForAnActivity(Activity $activity)
    {
        $query =  $this->createQueryBuilder('ap')
            ->join('ap.activity', 'a')

            ->andWhere('ap.activity = :activity')
            ->setParameter('activity', $activity)

            ->orderBy('a.startAt', 'ASC')
            ->addOrderBy('a.endAt', 'ASC')
            ->getQuery();

        $result = $query->getResult();

        return $result;
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
