<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 21/05/19
 * Time: 3:31
 */

namespace App\Controller\Actions\Activity;


use App\Managers\Activity\ActivityManager;
use Exception;

class GetUserRelatedFeedbackForAnActivityAndAUser
{

    private $activityManager;

    public function __construct(ActivityManager $activityManager)
    {
        $this->activityManager = $activityManager;
    }

    /**
     * @param $data
     * @return array
     * @throws Exception
     */
    public function __invoke($data, $id)
    {
        $userRelatedFeedbacks = $this->activityManager->getUserRelatedFeedbackForAnActivity($id);

        return $userRelatedFeedbacks;
    }

}