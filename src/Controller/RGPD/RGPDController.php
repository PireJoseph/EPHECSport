<?php

namespace App\Controller\RGPD;

use App\Managers\User\UserManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RGPDController extends AbstractController
{
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @Route("register", name="app_unregister")
     */
    public function unRegister()
    {

        $connectedUser = $this->get('security.context')->getToken()->getUser();

        try {
            $this->userManager->deleteUserData($connectedUser);
            $this->userManager->removeUser($connectedUser);
        }
        catch (Exception $e)
        {

        }

        // redirects to the "homepage" route
        return $this->redirectToRoute('default');
    }
}
