<?php

namespace App\Controller;

use App\Entity\Activity\Activity;
use App\Entity\Promotion\EmeritusSportMan;
use App\Entity\Promotion\OfficialTeam;
use App\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="default")
     */
    public function index()
    {

        $userNumber = count($this->em->getRepository(User::class)->findAll());
        $activityNumber = count($this->em->getRepository(Activity::class)->findAll());
        $teamNumber =  count($this->em->getRepository(OfficialTeam::class)->findAll());
        $highLevelSportManNumber = count($this->em->getRepository(EmeritusSportMan::class)->findAll());

        return $this->render('default.html.twig', [
            'controller_name' => 'DefaultController',
            'userNumber' => $userNumber,
            'activityNumber' => $activityNumber,
            'teamNumber' => $teamNumber,
            'highLevelSportManNumber' => $highLevelSportManNumber
        ]);


    }
}
