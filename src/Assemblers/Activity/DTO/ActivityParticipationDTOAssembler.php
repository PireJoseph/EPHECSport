<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 25/04/19
 * Time: 23:37
 */

namespace App\Assemblers\Activity\DTO;


use App\Entity\Activity\ActivityParticipation;
use App\Entity\Activity\DTO\ActivityParticipationDTO;

class ActivityParticipationDTOAssembler
{

    public function getFromActivityParticipationForAppCommon(ActivityParticipation $activityParticipation)
    {

        $activityParticipationDTO = new ActivityParticipationDTO();

        $activityParticipationDTO->activityParticipationId = $activityParticipation->getId();

        $activityParticipationDTO->userId = $activityParticipation->getUser()->getId();
        $activityParticipationDTO->userUsername = $activityParticipation->getUser()->getUsername();

        $activityParticipationDTO->activityId = $activityParticipation->getActivity()->getId();
        $activityParticipationDTO->activityLabel = $activityParticipation->getActivity()->getLabel();
        $activityParticipationDTO->activityStartAt = $activityParticipation->getActivity()->getStartAt()->format('Y-m-d H:i:s');
        if (!is_null($activityParticipation->getActivity()->getLocation()))
        {
            $activityParticipationDTO->activityLocation = $activityParticipation->getActivity()->getLocation()->getString();
        }

        return $activityParticipationDTO;

    }

}