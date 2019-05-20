<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 19/05/19
 * Time: 12:55
 */

namespace App\Api\Providers\Activity;


use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Activity\ActivityParticipation;
use App\Managers\Activity\ActivityManager;

class ActivityParticipationForAnActivityCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{


    private $activityManager;

    public function __construct(ActivityManager $activityManager)
    {
        $this->activityManager = $activityManager;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return ( (ActivityParticipation::class === $resourceClass) && ( ("getParticipationsForAnActivity" === $operationName) ));
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
        foreach ($this->activityManager->getActivityParticipationsForAnActivity() as $activityParticipation)
        {
            yield $activityParticipation;
        }

    }



}