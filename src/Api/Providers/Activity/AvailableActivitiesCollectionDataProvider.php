<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 13/05/19
 * Time: 17:37
 */

namespace App\Api\Providers\Activity;


use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Entity\Activity\Activity;
use App\Managers\Activity\ActivityManager;

class AvailableActivitiesCollectionDataProvider implements  CollectionDataProviderInterface, RestrictedDataProviderInterface
{

    private $activityManager;

    public function __construct(ActivityManager $activityManager)
    {
        $this->activityManager = $activityManager;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return ( (Activity::class === $resourceClass) && ( ("getAvailableActivities" === $operationName) ));
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
        $test = 'hehe';
        foreach ($this->activityManager->getAvailableActivities() as $availableActivity)
        {
            yield $availableActivity;
        }

    }



}