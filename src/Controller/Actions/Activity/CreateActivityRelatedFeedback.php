<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 13/05/19
 * Time: 10:39
 */

namespace App\Controller\Actions\Activity;


use App\Entity\Activity\ActivityRelatedFeedback;
use App\Managers\Activity\ActivityManager;
use Exception;

class CreateActivityRelatedFeedback
{
    private $activityManager;

    public function __construct(ActivityManager $activityManager)
    {
        $this->activityManager = $activityManager;
    }

    /**
     * @param ActivityRelatedFeedback $data
     * @return ActivityRelatedFeedback
     * @throws Exception
     */
    public function __invoke(ActivityRelatedFeedback $data): ActivityRelatedFeedback
    {

        return $data;
    }
}