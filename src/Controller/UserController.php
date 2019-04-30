<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{section}", name="user", defaults={"section"="home"} )
     */
    public function index($section)
    {
//        $this->denyAccessUnlessGranted('ROLE_USER');
//
//        $usr = $this->get('security.token_storage')->getToken()->getUser();
//
//        $userId = $usr->getId();

        return $this->render('user/index.html.twig', [
//            'currentUserId' => $userId
        ]);
    }


    /**
     * @Route("/user/{section}/{subroute}", name="userRedirect" )
     */
    public function subRouteRedirection()
    {
        return $this->redirect('/user/home');
    }
}
