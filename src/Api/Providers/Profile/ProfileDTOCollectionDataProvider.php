<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 7/05/19
 * Time: 1:02
 */

namespace App\Api\Providers\Profile;


use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Profile\DTO\ProfileDTO;
use App\Managers\User\UserManager;

class ProfileDTOCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return ProfileDTO::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null): \Generator
    {
        // Retrieve the blog post collection from somewhere
//        yield $this->userManager->getOtherProfiles();
        foreach ($this->userManager->getOtherProfiles() as $profileDTO)
        {
            yield $profileDTO;
        }

    }
}