<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 10/01/19
 * Time: 13:58
 */

namespace App\Controller\Providers\User;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use App\Controller\Managers\User\UserManager;
use App\Entity\User\User;
use App\Entity\User\DTO\UserDTO;
use Exception;

class UserDTOItemDataProvider  implements ItemDataProviderInterface
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
     * @return UserDTO|\null
     * @throws Exception
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        // Retrieve the UserDTO item from somewhere then return it or null if not found
        $test = 'hehe';
        return $this->userManager->getUserDTO($id);
    }

}