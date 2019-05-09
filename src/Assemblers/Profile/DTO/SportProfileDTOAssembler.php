<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 8/05/19
 * Time: 20:18
 */

namespace App\Assemblers\Profile\DTO;


use App\Assemblers\Activity\DTO\SportDTOAssembler;
use App\Entity\Profile\DTO\SportProfileDTO;
use App\Entity\Profile\SportProfile;

class SportProfileDTOAssembler
{
    private $sportDTOAssembler;

    public function __construct(SportDTOAssembler $sportDTOAssembler)
    {
        $this->sportDTOAssembler = $sportDTOAssembler;
    }

    public function getFromSportProfileForAppCommon(SportProfile $sportProfile)
    {
        $sportProfileDTO = new SportProfileDTO();

        $sportProfileDTO->id = $sportProfile->getId();
        $sport = $sportProfile->getSport();
        if(!is_null($sport))
        {
            $sportProfileDTO->sportDTO = $this->sportDTOAssembler->getForSportForAppCommon($sport);
            $sportProfileDTO->sportId = $sport->getId();
        }

        $sportProfileDTO->role = $sportProfile->getRole();
        $sportProfileDTO->level = $sportProfile->getLevel();
        $sportProfileDTO->isAimingFun = $sportProfile->getIsAimingFun();
        $sportProfileDTO->isAimingPerf = $sportProfile->getIsAimingPerf();
        $sportProfileDTO->wantedTimesPerWeek = $sportProfile->getWantedTimesPerWeek();
        $sportProfileDTO->wantToBeNotifiedAboutThisSport = $sportProfile->getWantToBeNotifiedAboutThisSport();
        $sportProfileDTO->isVisible = $sportProfile->getIsVisible();

        return $sportProfileDTO;
    }

}