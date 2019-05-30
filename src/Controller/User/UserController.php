<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{section}", name="user", defaults={"section"="home"} )
     */
    public function index($section)
    {
        return $this->render('user/index.html.twig');
    }


    /**
     * @Route("/user/{section}/{subroute}", name="userRedirect" )
     */
    public function subRouteRedirection()
    {
        return $this->redirect('/user/home');
    }
}
