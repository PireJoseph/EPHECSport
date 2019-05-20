<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 19/05/19
 * Time: 13:17
 */

namespace App\Controller\Actions\Activity;


use App\Managers\Activity\ActivityManager;
use Exception;

class GetActivityParticipationsForAnActivity
{
    private $activityManager;

    public function __construct(ActivityManager $activityManager)
    {
        $this->activityManager = $activityManager;
    }

    /**
     * @param $data
     * @param $id
     * @return array
     * @throws \App\Exception\ItemNotFoundException
     */
    public function __invoke($data, $id)
    {
        $availableActivities = $this->activityManager->getActivityParticipationsForAnActivity($id);

        return $availableActivities;
    }
}