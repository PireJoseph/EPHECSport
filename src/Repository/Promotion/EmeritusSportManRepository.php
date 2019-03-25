<?php

namespace App\Repository\Promotion;

use App\Entity\Promotion\EmeritusSportMan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EmeritusSportMan|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmeritusSportMan|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmeritusSportMan[]    findAll()
 * @method EmeritusSportMan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmeritusSportManRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EmeritusSportMan::class);
    }

    // /**
    //  * @return EmeritusSportMan[] Returns an array of EmeritusSportMan objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EmeritusSportMan
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
