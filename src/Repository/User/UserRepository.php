<?php

namespace App\Repository\User;

use App\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param string $username
     * @return User|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByUsername(string $username) : ?User
    {
        $query =  $this
            ->createQueryBuilder('u')
            ->andWhere('u.username = :usernameParam')
            ->setParameter('usernameParam', $username)
            ->setMaxResults(1)
            ->getQuery();

        $userFound = $query->getOneOrNullResult();

        return $userFound;

    }

    /**
     * @param string $email
     * @return User|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByEmail(string $email) : ?User
    {
        $query =  $this
            ->createQueryBuilder('u')
            ->andWhere('u.email = :emailParam')
            ->setParameter('emailParam', $email)
            ->setMaxResults(1)
            ->getQuery();

        $userFound = $query->getOneOrNullResult();

        return $userFound;

    }

    public function getOthers($id)
    {
        $query =  $this
            ->createQueryBuilder('u')
            ->andWhere('u.id != :idParam')
            ->setParameter(':idParam', $id)
            ->andWhere('u.roles not LIKE :roles')
//            on ne prends pas les admins
            ->setParameter(':roles', '%"ROLE_ADMIN"%')
            ->getQuery();
        return $query->getResult();
    }

    // /**
    //  * @return User[] Returns an array of User objects
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
    public function findOneBySomeField($value): ?User
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
