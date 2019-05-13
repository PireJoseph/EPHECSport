<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 9/05/19
 * Time: 23:50
 */

namespace App\Api\Providers\Activity;


use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Entity\Activity\Activity;
use App\Managers\Activity\ActivityManager;

class ActivityCollectionDataProvider  implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{

    private $activityManager;

    public function __construct(ActivityManager $activityManager)
    {
        $this->activityManager = $activityManager;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Activity::class === $resourceClass;
    }

    /**
     * Retrieves a collection.
     *
     * @throws ResourceClassNotSupportedException
     *
     * @return array|\Traversable
     */
    public function getCollection(string $resourceClass, string $operationName = null)
    {
        foreach ($this->activityManager->getActivityHistory() as $activity)
        {
            yield $activity;
        }
    }
}