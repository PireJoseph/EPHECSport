<?php

namespace App\Repository\Promotion;

use App\Entity\Promotion\ShoutOut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ShoutOut|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoutOut|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoutOut[]    findAll()
 * @method ShoutOut[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoutOutRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ShoutOut::class);
    }

    // /**
    //  * @return ShoutOut[] Returns an array of ShoutOut objects
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
    public function findOneBySomeField($value): ?ShoutOut
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
