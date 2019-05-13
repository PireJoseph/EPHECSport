<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 13/05/19
 * Time: 10:33
 */

namespace App\Api\Persisters\Activity;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Activity\ActivityRelatedFeedback;
use App\Managers\Activity\ActivityManager;

class ActivityRelatedFeedbackDataPersister implements DataPersisterInterface
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
        return $data instanceof ActivityRelatedFeedback;
    }

    /**
     * Persists the data.
     *
     * @return object
     */
    public function persist($data)
    {
       return $this->activityManager->persistActivityRelatedFeedback($data);
    }

    /**
     * Removes the data.
     */
    public function remove($data)
    {
        // TODO: Implement remove() method.
    }
}