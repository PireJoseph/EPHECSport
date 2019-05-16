<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 16/05/19
 * Time: 4:01
 */

namespace App\Api\Persisters\Activity;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Activity\ActivityParticipation;
use App\Managers\Activity\ActivityManager;

class ActivityParticipationDataPersister implements DataPersisterInterface
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
        return $data instanceof ActivityParticipation;
    }

    /**
     * Persists the data.
     *
     * @param $data
     * @return object
     */
    public function persist($data)
    {
        return $this->activityManager->persistActivityParticipation($data);
    }

    /**
     * Removes the data.
     */
    public function remove($data)
    {
        // TODO: Implement remove() method.
    }

}
