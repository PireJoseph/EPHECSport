<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 26/04/19
 * Time: 17:40
 */

namespace App\Assemblers\Activity\DTO;


use App\Entity\Activity\DTO\SportDTO;
use App\Entity\Activity\Sport;

class SportDTOAssembler
{

    public function getForSportForAppCommon(Sport $sport)
    {
        $sportDTO = new SportDTO();

        $sportDTO->id = $sport->getId();
        $sportDTO->label = $sport->getLabel();

        return $sportDTO;
    }

}