<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 9/05/19
 * Time: 0:18
 */

namespace App\Api\Providers\Profile;


use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Assemblers\Profile\DTO\SportProfileDTOAssembler;
use App\Entity\Profile\DTO\SportProfileDTO;
use App\Managers\User\UserManager;

class SportProfileDTOItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private $userManager;
    private $sportProfileDTOAssembler;

    public function __construct(UserManager $userManager, SportProfileDTOAssembler $sportProfileDTOAssembler)
    {
        $this->userManager = $userManager;
        $this->sportProfileDTOAssembler = $sportProfileDTOAssembler;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return SportProfileDTO::class === $resourceClass;
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

        $sportProfile = $this->userManager->getSportProfile($id);

        if (is_null($sportProfile))
        {
            return null;
        }

        $sportProfileDTO = $this->sportProfileDTOAssembler->getFromSportProfileForAppCommon($sportProfile);

        return $sportProfileDTO;
    }
}