<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 19/05/19
 * Time: 13:53
 */

namespace App\Api\Persisters\Activity;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Activity\UserRelatedFeedback;
use App\Managers\Activity\ActivityManager;

class UserRelatedFeedbackDataPersister implements DataPersisterInterface
{
    private $activityManager;

    public function __construct(ActivityManager $activityManager)
    {
        $this->activityManager = $activityManager;
    }

    /**
     * Is the data supported by the persister?
     * @param $data
     * @return bool
     */
    public function supports($data): bool
    {
        return $data instanceof UserRelatedFeedback;
    }

    /**
     * Persists the data.
     *
     * @return object
     */
    public function persist($data)
    {
        return $this->activityManager->persistUserRelatedFeedback($data);
    }

    /**
     * Removes the data.
     */
    public function remove($data)
    {
        // TODO: Implement remove() method.
    }
}