<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 26/04/19
 * Time: 17:39
 */

namespace App\Assemblers\Promotion\DTO;


use App\Assemblers\Activity\DTO\SportClubDTOAssembler;
use App\Assemblers\Activity\DTO\SportDTOAssembler;
use App\Assemblers\Profile\DTO\PictureDTOAssembler;
use App\Entity\Activity\SportClub;
use App\Entity\Promotion\DTO\EmeritusSportManDTO;
use App\Entity\Promotion\EmeritusSportMan;

class EmeritusSportManDTOAssembler
{

    private $sportDTOAssembler;
    private $pictureDTOAssembler;
    private $sportClubDTOAssembler;

    public function __construct(SportDTOAssembler $sportDTOAssembler, PictureDTOAssembler $pictureDTOAssembler, SportClubDTOAssembler $sportClubDTOAssembler)
    {
        $this->sportDTOAssembler = $sportDTOAssembler;
        $this->pictureDTOAssembler = $pictureDTOAssembler;
        $this->sportClubDTOAssembler = $sportClubDTOAssembler;
    }

    public function getFromEmeritusSportManForAppCommon(EmeritusSportMan $emeritusSportMan)
    {
        $emeritusSportManDTO = new EmeritusSportManDTO();

        $emeritusSportManDTO->id = $emeritusSportMan->getId();
        $emeritusSportManDTO->firstName = $emeritusSportMan->getFirstName();
        $emeritusSportManDTO->lastName = $emeritusSportMan->getLastName();
        $emeritusSportManDTO->nickName = $emeritusSportMan->getNickName();
        $emeritusSportManDTO->gender = $emeritusSportMan->getGender();
        $emeritusSportManDTO->role = $emeritusSportMan->getRole();
        $sport = $emeritusSportMan->getSport();
        $emeritusSportManDTO->sportDTO = (is_null($sport)) ? null : $this->sportDTOAssembler->getForSportForAppCommon($sport);
        $sportClub = $emeritusSportMan->getSportClub();
        $emeritusSportManDTO->sportClubDTO = (is_null($sportClub)) ? null : $this->sportClubDTOAssembler->getFromSportClubForAppCommon($sportClub);
        $picturesDTOs = [];
        foreach ($emeritusSportMan->getPictures() as $picture)
        {
            $picturesDTOs[] = $this->pictureDTOAssembler->getFromPicture($picture);
        }
        $emeritusSportManDTO->picturesDTOs = $picturesDTOs;

        return $emeritusSportManDTO;

    }

}