<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 8/05/19
 * Time: 22:47
 */

namespace App\Api\Persisters\Profile;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Profile\DTO\ProfileDTO;
use App\Entity\Profile\DTO\SportProfileDTO;
use App\Managers\User\UserManager;

class SportProfileDTODataPersister implements DataPersisterInterface
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
        return $data instanceof SportProfileDTO;
    }


    /**
     * Persists the data.
     *
     * @param $data
     * @return SportProfileDTO $sportProfileDTO
     * @throws \Exception
     */
    public function persist($data)
    {
        $dataId = $data->id;
        if(!is_null($dataId))
        {
            $sportProfileDTO = $this->userManager->updateSportProfileFromDTO($data);
        }
        else
        {
            $sportProfileDTO = $this->userManager->createSportProfileFromDTO($data);
        }
        return $sportProfileDTO;
    }

    /**
     * Removes the data.
     */
    public function remove($data)
    {
        // TODO: Implement remove() method.
    }
}