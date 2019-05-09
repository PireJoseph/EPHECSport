<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 23/04/19
 * Time: 0:35
 */

namespace App\Assemblers;


use App\Assemblers\Activity\DTO\SportDTOAssembler;
use App\Assemblers\User\DTO\UserDTOAssembler;
use App\Entity\AppCommonDTO;
use App\Entity\User\User;

class AppCommonDTOAssembler
{

    private $userDTOAssembler;
    private $sportDTOAssembler;

    public function __construct(UserDTOAssembler $userDTOAssembler, SportDTOAssembler $sportDTOAssembler){
        $this->userDTOAssembler = $userDTOAssembler;
        $this->sportDTOAssembler = $sportDTOAssembler;
    }

    /**
     * @param User $user
     * @param $sports
     * @return AppCommonDTO
     */
    public function getFromUser(User $user, $sports){

        $appCommonDTO = new AppCommonDTO();
        $appCommonDTO->id = $user->getId();

        $userDTO = $this->userDTOAssembler->getFromUser($user);
        $appCommonDTO->userDTO = $userDTO;

        $sportDTOs = [];
        foreach( $sports as $sport)
        {
            $sportDTOs[] = $this->sportDTOAssembler->getForSportForAppCommon($sport);
        }
        $appCommonDTO->sportDTOs = $sportDTOs;

        return $appCommonDTO;

    }


}