<?php

namespace App\Repository\Promotion;

use App\Entity\Promotion\CrucialMeeting;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Exception;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CrucialMeeting|null find($id, $lockMode = null, $lockVersion = null)
 * @method CrucialMeeting|null findOneBy(array $criteria, array $orderBy = null)
 * @method CrucialMeeting[]    findAll()
 * @method CrucialMeeting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CrucialMeetingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CrucialMeeting::class);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function getNext()
    {

        $now = new DateTime();
        $qb = $this->createQueryBuilder('cm');
        $lastResult = $qb
            ->where('cm.startAt > :now')
            ->setParameter('now', $now)
            ->orderBy('cm.startAt', 'ASC')
            ->getQuery()
            ->setMaxResults(1)
            ->getResult();
        return $lastResult;
    }

    /**
     * @throws Exception
     */
    public function getNexts()
    {
        $now = new DateTime();

        $query = $this->createQueryBuilder('cm')
            ->where('cm.startAt > :now')
            ->setParameter('now', $now)
            ->orderBy('cm.startAt', 'ASC')
            ->getQuery();

        $result = $query->getResult();

        return $result;
    }

    // /**
    //  * @return CrucialMeeting[] Returns an array of CrucialMeeting objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CrucialMeeting
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
