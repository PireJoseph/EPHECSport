<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 19/05/19
 * Time: 0:37
 */

namespace App\Api\Providers\Promotion;


use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Entity\Promotion\DTO\OfficialTeamDTO;
use App\Entity\Promotion\OfficialTeam;
use App\Managers\Promotion\PromotionManager;

class OfficialTeamItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
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


    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
       return $this->promotionManager->getOfficialTeam($id);
    }

}