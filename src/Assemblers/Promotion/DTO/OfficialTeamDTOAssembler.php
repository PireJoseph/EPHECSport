<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 26/04/19
 * Time: 17:39
 */

namespace App\Assemblers\Promotion\DTO;


use App\Assemblers\Activity\DTO\SportDTOAssembler;
use App\Assemblers\Profile\DTO\PictureDTOAssembler;
use App\Entity\Promotion\DTO\OfficialTeamDTO;
use App\Entity\Promotion\OfficialTeam;

class OfficialTeamDTOAssembler
{

    private $sportDTOAssembler;
    private $pictureDTOAssembler;

    public function __construct(SportDTOAssembler $sportDTOAssembler, PictureDTOAssembler $pictureDTOAssembler)
    {
        $this->sportDTOAssembler = $sportDTOAssembler;
        $this->pictureDTOAssembler = $pictureDTOAssembler;
    }

    public function getFromOfficialTeamForAppCommon(OfficialTeam $officialTeam)
    {

        $officialTeamDTO = new OfficialTeamDTO();

        $officialTeamDTO->id = $officialTeam->getId();
        $officialTeamDTO->label = $officialTeam->getLabel();
        $officialTeamDTO->name = $officialTeam->getName();
        $officialTeamDTO->shortName = $officialTeam->getShortName();
        $officialTeamDTO->nickName = $officialTeam->getNickName();
        $sport = $officialTeam->getSport();
        $officialTeamDTO->sportDTO = (is_null($sport)) ? null : $this->sportDTOAssembler->getForSportForAppCommon($sport);
        $picturesDTOs = [];
        foreach ($officialTeam->getPictures() as $picture)
        {
            $picturesDTOs[] = $this->pictureDTOAssembler->getFromPicture($picture);
        }
        $officialTeamDTO->pictureDTOs = $picturesDTOs;

        return $officialTeamDTO;

    }

}