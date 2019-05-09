<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 1/05/19
 * Time: 8:34
 */

namespace App\Api\Providers\Profile;


use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Assemblers\Profile\DTO\ProfileDTOAssembler;
use App\Entity\Profile\DTO\ProfileDTO;
use App\Managers\User\UserManager;
use Exception;

class ProfileDTOItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{

    private $userManager;
    private $profileDTOAssembler;

    public function __construct(UserManager $userManager, ProfileDTOAssembler $profileDTOAssembler)
    {
        $this->userManager = $userManager;
        $this->profileDTOAssembler = $profileDTOAssembler;
    }


    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return ProfileDTO::class === $resourceClass;
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
     * @throws Exception
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {

        $user = $this->userManager->getUser($id);
        if (is_null($user))
        {
            return null;
        }
        $profileDTO = $this->profileDTOAssembler->getFromUser($user, $user);

        return $profileDTO;

    }


}