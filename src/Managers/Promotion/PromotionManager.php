<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 17/05/19
 * Time: 12:02
 */

namespace App\Managers\Promotion;


use App\Entity\Promotion\CrucialMeeting;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class PromotionManager
{

    private $em;
    private $security;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->em = $entityManager;
    }

    public function getNextCrucialMeetings()
    {
        $meetingsQueryResult = $this->em->getRepository(CrucialMeeting::class)->getNexts();
        return $meetingsQueryResult;

    }


}