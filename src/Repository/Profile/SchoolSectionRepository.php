<?php

namespace App\Repository\Profile;

use App\Entity\Profile\SchoolSection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SchoolSection|null find($id, $lockMode = null, $lockVersion = null)
 * @method SchoolSection|null findOneBy(array $criteria, array $orderBy = null)
 * @method SchoolSection[]    findAll()
 * @method SchoolSection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SchoolSectionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SchoolSection::class);
    }

    // /**
    //  * @return SchoolSection[] Returns an array of SchoolSection objects
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
    public function findOneBySomeField($value): ?SchoolSection
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
