<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 11/01/19
 * Time: 3:12
 */

namespace App\Api\Persisters\User;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Managers\User\UserManager;
use App\Entity\User\DTO\UserDTO;

class UserDTODataPersister implements DataPersisterInterface
{

    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * Is the data supported by the persister?
     * @param $data
     * @return bool
     */
    public function supports($data): bool
    {
        return $data instanceof UserDTO;
    }

    /**
     * Persists the data.
     *
     * @param $data
     * @return object
     * @throws \Exception
     */
    public function persist($data)
    {
        return $this->userManager->createUserFromDTO($data);
    }

    /**
     * Removes the data.
     * @param $data
     */
    public function remove($data)
    {
        // TODO: Implement remove() method.
    }
}