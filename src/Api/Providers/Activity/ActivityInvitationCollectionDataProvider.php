<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 15/05/19
 * Time: 0:12
 */

namespace App\Api\Providers\Activity;


use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Activity\ActivityInvitation;
use App\Managers\Activity\ActivityManager;

class ActivityInvitationCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $activityManager;

    public function __construct(ActivityManager $activityManager)
    {
        $this->activityManager = $activityManager;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return ( (ActivityInvitation::class === $resourceClass) && ( ("getInvitations" === $operationName) ));
    }

    /**
     * Retrieves a collection.
     *
     * @param string $resourceClass
     * @param string|null $operationName
     * @return array|\Traversable
     */
    public function getCollection(string $resourceClass, string $operationName = null)
    {
        foreach ($this->activityManager->getActivityInvitations() as $activityInvitation)
        {
            yield $activityInvitation;
        }

    }

}