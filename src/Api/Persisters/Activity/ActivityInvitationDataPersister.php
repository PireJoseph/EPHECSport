<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 15/05/19
 * Time: 0:54
 */

namespace App\Api\Persisters\Activity;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Activity\ActivityInvitation;
use App\Managers\Activity\ActivityManager;
use Exception;

class ActivityInvitationDataPersister implements DataPersisterInterface
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
        return $data instanceof ActivityInvitation;
    }

    /**
     * Persists the data.
     *
     * @param $data
     * @return object will not be supported in API Platform 3, an object should always be returned
     * @throws Exception
     */
    public function persist($data)
    {
        return $this->activityManager->answerActivityInvitation($data);
    }

    /**
     * Removes the data.
     */
    public function remove($data)
    {
        // TODO: Implement remove() method.
    }
}