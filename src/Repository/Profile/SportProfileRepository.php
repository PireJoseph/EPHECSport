<?php

namespace App\Repository\Profile;

use App\Entity\Profile\SportProfile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SportProfile|null find($id, $lockMode = null, $lockVersion = null)
 * @method SportProfile|null findOneBy(array $criteria, array $orderBy = null)
 * @method SportProfile[]    findAll()
 * @method SportProfile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SportProfileRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SportProfile::class);
    }

    // /**
    //  * @return SportProfile[] Returns an array of SportProfile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SportProfile
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
