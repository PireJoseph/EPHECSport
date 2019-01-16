<?php

namespace App\Controller\Actions\User;

use App\Controller\Actions\APIAction;
use App\Controller\Managers\User\UserManager;
use App\Entity\User\DTO\UserDTO;
use Exception;

class GetUserAction extends APIAction
{
    private $userManager;

    // passing dependencies
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }


    /**
     * @param UserDTO $data
     * @return UserDTO|Exception
     * @throws Exception
     */
    public function __invoke(UserDTO $data)
    {

//        $newData = $this->userManager->getUserFromDTO($data); // Warning: the __invoke() method parameter MUST be called $data, otherwise, it will not be filled correctly!


        return $data;

    }

}
