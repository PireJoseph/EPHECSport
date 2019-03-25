<?php

namespace App\Repository\Promotion;

use App\Entity\Promotion\OfficialTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OfficialTeam|null find($id, $lockMode = null, $lockVersion = null)
 * @method OfficialTeam|null findOneBy(array $criteria, array $orderBy = null)
 * @method OfficialTeam[]    findAll()
 * @method OfficialTeam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfficialTeamRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OfficialTeam::class);
    }

    // /**
    //  * @return OfficialTeam[] Returns an array of OfficialTeam objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OfficialTeam
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
