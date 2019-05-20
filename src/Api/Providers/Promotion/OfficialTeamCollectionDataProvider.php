<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 19/05/19
 * Time: 0:37
 */

namespace App\Api\Providers\Promotion;


use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Promotion\DTO\OfficialTeamDTO;
use App\Entity\Promotion\OfficialTeam;
use App\Managers\Promotion\PromotionManager;

class OfficialTeamCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{

    private $promotionManager;

    public function __construct(PromotionManager $promotionManager)
    {
        $this->promotionManager = $promotionManager;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return OfficialTeam::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null): \Generator
    {

        foreach ($this->promotionManager->getOfficialTeams() as $officialTeam)
        {
            yield $officialTeam;
        }

    }
}