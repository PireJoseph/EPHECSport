<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 10/01/19
 * Time: 0:54
 */

namespace App\Controller\Actions\User;


use App\Controller\Actions\APIAction;
use App\Controller\Managers\User\UserManager;
use App\Entity\User\DTO\UserDTO;
use Exception;

class PostUserAction extends APIAction
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
     */
    public function __invoke(UserDTO $data)
    {
        try {
            $newData = $this->userManager->createUserFromDTO($data); // Warning: the __invoke() method parameter MUST be called $data, otherwise, it will not be filled correctly!
        } catch (Exception $e){
            return $e;
        }
        return $newData;
    }


}