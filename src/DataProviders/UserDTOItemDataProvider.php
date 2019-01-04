<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 4/01/19
 * Time: 18:13
 */

namespace App\DataProviders;


use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Controller\APIManagers\User\UserManager;
use App\Entity\User\DTO\UserDTO;

class UserDTOItemDataProvider implements ItemDataProviderInterface
{

    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return UserDTO::class === $resourceClass;
    }

    /**
     * Retrieves an item.
     *
     * @param string $resourceClass
     * @param array|int|string $id
     *
     * @param string|null $operationName
     * @param array $context
     * @return UserDTO|\Exception
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        // Retrieve the UserDTO item from somewhere then return it or null if not found
        return $this->userManager->getUserDTO($id);

    }
}