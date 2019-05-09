<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 9/05/19
 * Time: 15:14
 */

namespace App\Controller\Actions\Profile;


use App\Entity\Profile\DTO\SportProfileDTO;
use App\Managers\User\UserManager;
use Exception;

class CreateSportProfile
{
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param SportProfileDTO $data
     * @return SportProfileDTO
     * @throws Exception
     */
    public function __invoke(SportProfileDTO $data): SportProfileDTO
    {
       $persistedSportProfile = $this->userManager->createSportProfileFromDTO($data);

       $data->id = $persistedSportProfile->id ;

        return $data;
    }
}