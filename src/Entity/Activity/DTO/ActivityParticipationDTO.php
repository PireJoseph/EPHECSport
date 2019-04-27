<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 25/04/19
 * Time: 23:25
 */

namespace App\Entity\Activity\DTO;


class ActivityParticipationDTO
{

    public $activityParticipationId;

    public $activityId;

    public $activityLabel;

    public $activityStartAt;

    public $activityLocation;

    public $userId;

    public $userUsername;

    public $isConfirmed;

}