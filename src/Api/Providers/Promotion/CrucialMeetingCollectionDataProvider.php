<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 17/05/19
 * Time: 12:01
 */

namespace App\Api\Providers\Promotion;


use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Promotion\CrucialMeeting;
use App\Managers\Promotion\PromotionManager;

class CrucialMeetingCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{

    private $promotionManager;

        public function __construct(PromotionManager $promotionManager)
    {
        $this->promotionManager = $promotionManager;
    }

        public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return CrucialMeeting::class === $resourceClass;
    }

        public function getCollection(string $resourceClass, string $operationName = null): \Generator
    {

        foreach ($this->promotionManager->getNextCrucialMeetings() as $crucialMeeting)
        {
            yield $crucialMeeting;
        }

    }

}