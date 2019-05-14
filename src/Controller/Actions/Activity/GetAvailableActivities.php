<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 13/05/19
 * Time: 22:07
 */

namespace App\Controller\Actions\Activity;


use App\Managers\Activity\ActivityManager;

class GetAvailableActivities
{
    private $activityManager;

    public function __construct(ActivityManager $activityManager)
    {
        $this->activityManager = $activityManager;
    }

    /**
     * @return
     * @throws Exception
     */
    public function __invoke($data)
    {
        $availableActivities = $this->activityManager->getAvailableActivities();

        return $availableActivities;
    }
}