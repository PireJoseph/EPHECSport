<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 9/05/19
 * Time: 17:28
 */

namespace App\Controller\Actions\Profile;

use App\Entity\Profile\DTO\ProfileDTO;
use App\Managers\User\UserManager;
use Exception;

class RemovePreferredPartner
{
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param ProfileDTO $data
     * @return ProfileDTO
     * @throws Exception
     */
    public function __invoke(ProfileDTO $data): ProfileDTO
    {
        $this->userManager->removePreferredPartner($data);

        return $data;
    }
}