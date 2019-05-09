<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 8/05/19
 * Time: 18:25
 */

namespace App\Managers\Activity;


use App\Entity\Activity\Sport;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class ActivityManager
{

    private $em;
    private $security;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->em = $entityManager;
    }

    public function getSports()
    {
       return  $this->em->getRepository(Sport::class)->findAll();
    }


}