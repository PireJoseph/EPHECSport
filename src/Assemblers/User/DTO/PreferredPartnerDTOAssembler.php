<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 24/04/19
 * Time: 5:00
 */

namespace App\Assemblers\User\DTO;


use App\Entity\User\DTO\PreferredPartnerDTO;
use App\Entity\User\User;

class PreferredPartnerDTOAssembler
{

    public function getFromUser(User $user)
    {
        $preferredPartnerDTO = new PreferredPartnerDTO();
        $preferredPartnerDTO->id = $user->getId();
        $preferredPartnerDTO->username = $user->getUsername();
        return $preferredPartnerDTO;
    }

}