<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 26/04/19
 * Time: 9:38
 */

namespace App\Assemblers\Promotion\DTO;


use App\Assemblers\Activity\DTO\SportDTOAssembler;
use App\Entity\Promotion\CrucialMeeting;
use App\Entity\Promotion\DTO\CrucialMeetingDTO;

class CrucialMeetingDTOAssembler
{

    private $sportDTOAssembler;
    private $emeritusSportManDTOAssembler;
    private $officialTeamDTOAssembler;

    public function __construct(SportDTOAssembler $sportDTOAssembler, EmeritusSportManDTOAssembler $emeritusSportManDTOAssembler, OfficialTeamDTOAssembler $officialTeamDTOAssembler)
    {
        $this->sportDTOAssembler = $sportDTOAssembler;
        $this->emeritusSportManDTOAssembler = $emeritusSportManDTOAssembler;
        $this->officialTeamDTOAssembler = $officialTeamDTOAssembler;
    }

    public function getFromCrucialMeetingForAppCommon(CrucialMeeting $crucialMeeting)
    {
        $crucialMeetingDTO = new CrucialMeetingDTO();

        $crucialMeetingDTO->crucialMeetingId = $crucialMeeting->getId();
        $crucialMeetingDTO->label = $crucialMeeting->getLabel();
        $crucialMeetingDTO->startAt = $crucialMeeting->getStartAt()->format('d/m/y');
        $crucialMeetingDTO->location = (is_null($crucialMeeting->getLocation())) ? null : $crucialMeeting->getLocation()->getString();
        $crucialMeetingDTO->comment = $crucialMeeting->getComment();
        $crucialMeetingDTO->endAt = (is_null($crucialMeeting->getEndAt())) ? null :$crucialMeeting->getEndAt()->format('d/m/y');
        $sportsDTOs = [];
        foreach ($crucialMeeting->getSports() as $sport)
        {
            $sportsDTOs[] = $this->sportDTOAssembler->getForSportForAppCommon($sport);
        }
        $crucialMeetingDTO->sportsDTOs = $sportsDTOs;
        $emeritusSportMenDTOs = [];
        foreach ($crucialMeeting->getEmeritusSportMen() as $emeritusSportMan)
        {
            $emeritusSportMenDTOs[] = $this->emeritusSportManDTOAssembler->getFromEmeritusSportManForAppCommon($emeritusSportMan);
        }
        $crucialMeetingDTO->emeritusSportMenDTOs = $emeritusSportMenDTOs;
        $officialTeamsDTOs = [];
        foreach ($crucialMeeting->getOfficialTeams() as $officialTeam)
        {
            $officialTeamsDTOs[] = $this->officialTeamDTOAssembler->getFromOfficialTeamForAppCommon($officialTeam);
        }
        $crucialMeetingDTO->officialTeamsDTOs = $officialTeamsDTOs;

        return $crucialMeetingDTO;

    }

}