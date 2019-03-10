<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {

        /** TODO  Implémenter les compteurs */

        $userNumber = 0;
        $activityNumber = 0;
        $teamNumber = 0;
        $highLevelSportManNumber = 0;

        return $this->render('default.html.twig', [
            'controller_name' => 'DefaultController',
            'userNumber' => $userNumber,
            'activityNumber' => $activityNumber,
            'teamNumber' => $teamNumber,
            'highLevelSportManNumber' => $highLevelSportManNumber
        ]);


    }
}
