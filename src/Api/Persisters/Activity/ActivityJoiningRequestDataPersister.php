<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 14/05/19
 * Time: 18:37
 */

namespace App\Api\Persisters\Activity;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Activity\ActivityJoiningRequest;
use App\Managers\Activity\ActivityManager;

class ActivityJoiningRequestDataPersister implements DataPersisterInterface
{

    private $activityManager;

    public function __construct(ActivityManager $activityManager)
    {
        $this->activityManager = $activityManager;
    }

    /**
     * Is the data supported by the persister?
     */
    public function supports($data): bool
    {
        return $data instanceof ActivityJoiningRequest;
    }

    /**
     * Persists the data.
     *
     * @return object Void will not be supported in API Platform 3, an object should always be returned
     */
    public function persist($data)
    {
        return $this->activityManager->makeActivityJoiningRequest($data);
    }

    /**
     * Removes the data.
     */
    public function remove($data)
    {
        // TODO: Implement remove() method.
    }
}