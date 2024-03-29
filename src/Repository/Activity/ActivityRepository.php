<?php

namespace App\Repository\Activity;

use App\Entity\Activity\Activity;
use App\Entity\Activity\ActivityParticipation;
use App\Entity\User\User;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Exception;
use Symfony\Bridge\Doctrine\RegistryInterface;


/**
 * @method Activity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activity[]    findAll()
 * @method Activity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Activity::class);
    }

    public function getHistoryForUser(User $user)
    {
        $now = new DateTime();
        $qb = $this->createQueryBuilder('a');
        $query = $qb
            ->join('App\Entity\Activity\ActivityParticipation', 'ap', 'WITH', 'ap.activity = a')
            ->where('a.startAt < :now')
            ->setParameter('now', $now)
            ->andWhere('ap.user = :user')
            ->setParameter('user', $user)
            ->orderBy('a.endAt', 'DESC')
            ->addOrderBy('a.startAt', 'DESC')
            ->getQuery();

        $result = $query->getResult();
        return $result;
    }

    /**
     * @param $activityIdsArray
     * @return mixed
     * @throws Exception
     */
    public function getAvailable($activityIdsArray)
    {
        $now = new DateTime();
        $qb = $this->createQueryBuilder('a');
        $query = $qb
            ->select('a')
            ->andWhere('a.isVisible = true')
            ->andWhere('a.isPublished = true')
            ->andWhere('a.startAt > :now')
            ->setParameter('now', $now)

            ->andWhere('a.id NOT in (:activityIdsArray)')
            ->setParameter('activityIdsArray', $activityIdsArray)

            ->orderBy('a.endAt', 'ASC')
            ->addOrderBy('a.startAt', 'ASC')

            ->getQuery();

        $result = $query->getResult();
        return $result;
    }



    // /**
    //  * @return Activity[] Returns an array of Activity objects
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
    public function findOneBySomeField($value): ?Activity
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
