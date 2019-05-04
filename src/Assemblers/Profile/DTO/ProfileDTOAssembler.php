<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 1/05/19
 * Time: 8:29
 */

namespace App\Assemblers\Profile\DTO;


use App\Entity\Profile\DTO\ProfileDTO;
use App\Entity\User\User;

class ProfileDTOAssembler
{



    public function getFromUser(User $user)
    {
        $profileDTO = new ProfileDTO();

        $profileDTO->id = $user->getId();
        $profileDTO->username = $user->getUsername();

        return $profileDTO;
    }

}