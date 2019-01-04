<?php

namespace App\Controller\APIActions\User;

use App\Controller\APIActions\APIAction;
use App\Controller\APIManagers\User\UserManager;
use App\Entity\User\DTO\UserDTO;

class CreateUserAction extends APIAction
{
    private $userManager;

    // passing dependencies
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }


    /**
     * @param UserDTO $data
     * @return UserDTO|\Exception
     * @throws \Exception
     */
    public function __invoke(UserDTO $data)
    {
//        $newData = $this->createUserHandler->handle($data); // Warning: the __invoke() method parameter MUST be called $data, otherwise, it will not be filled correctly!
        $newData = $this->userManager->createUserFromDTO($data);

        return $newData;

    }

}
