<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 23/04/19
 * Time: 0:35
 */

namespace App\Assemblers;


use App\Assemblers\User\DTO\UserDTOAssembler;
use App\Entity\AppCommonDTO;
use App\Entity\User\User;

class AppCommonDTOAssembler
{

    private $userDTOAssembler;

    public function __construct(UserDTOAssembler $userDTOAssembler){
        $this->userDTOAssembler = $userDTOAssembler;
    }

    /**
     * @param User $user
     * @return AppCommonDTO
     */
    public function getFromUser(User $user){
        $appCommonDTO = new AppCommonDTO();
        $appCommonDTO->id = $user->getId();

        $userDTO = $this->userDTOAssembler->getFromUser($user);
        $appCommonDTO->userDTO = $userDTO;

        return $appCommonDTO;
    }


}