<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 1/05/19
 * Time: 18:32
 */

namespace App\Api\Persisters\Profile;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Profile\DTO\ProfileDTO;
use App\Managers\User\UserManager;

class ProfileDTODataPersister implements DataPersisterInterface
{

    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * Is the data supported by the persister?
     */
    public function supports($data): bool
    {
        return $data instanceof ProfileDTO;
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
        if (!is_null($data->preferredPartnerId)) // si on est dans le cas d'ajout ou de suppression d'un partenaire sportif
        {
            return $data;
        }
        return $this->userManager->updateProfileFromDTO($data);
    }


    /**
     * Removes the data.
     */
    public function remove($data)
    {
        // TODO: Implement remove() method.
    }
}