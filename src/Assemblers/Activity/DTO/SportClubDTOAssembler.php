<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 27/04/19
 * Time: 6:10
 */

namespace App\Assemblers\Activity\DTO;


use App\Entity\Activity\DTO\SportClubDTO;
use App\Entity\Activity\SportClub;

class SportClubDTOAssembler
{

    private $sportDTOAssembler;

    public function __construct(SportDTOAssembler $sportDTOAssembler)
    {
        $this->sportDTOAssembler = $sportDTOAssembler;
    }

    public function getFromSportClubForAppCommon(SportClub $sportClub)
    {

        $sportClubDTO = new SportClubDTO();

        $sportClubDTO->id = $sportClub->getId();
        $sportClubDTO->label = $sportClub->getLabel();
        $sport = $sportClub->getSport();
        $sportClubDTO->sportDTO = $this->sportDTOAssembler->getForSportForAppCommon($sport);

        return $sportClubDTO;

    }

}