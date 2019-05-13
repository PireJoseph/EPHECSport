<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 10/05/19
 * Time: 12:37
 */

namespace App\Api\Providers\Activity;


use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Entity\Activity\ActivityRelatedFeedback;
use App\Managers\Activity\ActivityManager;

class ActivityHistoryRelatedFeedbackItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{

    private $activityManager;

    public function __construct(ActivityManager $activityManager)
    {
        $this->activityManager = $activityManager;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
       return ( (ActivityRelatedFeedback::class === $resourceClass) && ( ("post" === $operationName) || ("getActivityHistoryFeedback" === $operationName) ));
    }

    /**
     * Retrieves an item.
     *
     * @param array|int|string $id
     *
     * @throws ResourceClassNotSupportedException
     *
     * @return object|null
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        return $this->activityManager->getActivityFeedback($id);
    }



}