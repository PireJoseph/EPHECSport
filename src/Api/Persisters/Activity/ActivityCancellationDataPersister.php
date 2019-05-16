<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 16/05/19
 * Time: 7:26
 */

namespace App\Api\Persisters\Activity;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Activity\ActivityCancellation;
use App\Managers\Activity\ActivityManager;

class ActivityCancellationDataPersister implements DataPersisterInterface
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
        return $data instanceof ActivityCancellation;
    }

    /**
     * Persists the data.
     *
     * @param $data
     * @return object
     */
    public function persist($data)
    {
        return $this->activityManager->persistActivityCancellation($data);
    }

    /**
     * Removes the data.
     */
    public function remove($data)
    {
        // TODO: Implement remove() method.
    }

}
