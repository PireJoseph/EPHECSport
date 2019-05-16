<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 15/05/19
 * Time: 20:19
 */

namespace App\Api\Providers\Activity;


use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Activity\ActivityParticipation;
use App\Managers\Activity\ActivityManager;

class ActivityParticipationCollectionDataProvider  implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{


    private $activityManager;

    public function __construct(ActivityManager $activityManager)
    {
        $this->activityManager = $activityManager;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return ( (ActivityParticipation::class === $resourceClass) && ( ("getParticipations" === $operationName) ));
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
        foreach ($this->activityManager->getActivityParticipations() as $activityParticipation)
        {
            yield $activityParticipation;
        }

    }




}