<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 26/12/18
 * Time: 23:16
 */

namespace App\Controller\APIHandlers\User;


use App\Controller\APIHandlers\APIHandler;
use App\Controller\APIManagers\User\UserManager;
use App\Entity\User\DTO\UserDTO;
use Exception;

class CreateUserHandler extends APIHandler
{

    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param UserDTO $data
     * @return UserDTO|Exception
     * @throws Exception
     */
    public function handle(UserDTO $data)
    {
        return $this->userManager->createUserFromDto($data);

    }

}