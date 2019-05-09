<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 22/04/19
 * Time: 21:57
 */

namespace App\Api\Providers;


use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Assemblers\AppCommonDTOAssembler;
use App\Entity\AppCommonDTO;
use App\Managers\Activity\ActivityManager;
use App\Managers\User\UserManager;

class AppCommonDTOItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private $userManager;
    private $activityManager;
    private $appCommonDTOAssembler;

    public function __construct(UserManager $userManager, AppCommonDTOAssembler $appCommonDTOAssembler, ActivityManager $activityManager)
    {
        $this->userManager = $userManager;
        $this->appCommonDTOAssembler = $appCommonDTOAssembler;
        $this->activityManager = $activityManager;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return AppCommonDTO::class === $resourceClass;
    }

    /**
     * Retrieves an item.
     *
     * @param string $resourceClass
     * @param array|int|string $id
     *
     * @param string|null $operationName
     * @param array $context
     * @return object|null
     * @throws \Exception
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {

        $user = $this->userManager->getUser($id);
        if (is_null($user))
        {
            return null;
        }

        $sports = $this->activityManager->getSports();

        $appCommonDTO = $this->appCommonDTOAssembler->getFromUser($user, $sports);

        return $appCommonDTO;

    }
}