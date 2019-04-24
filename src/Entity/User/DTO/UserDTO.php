<?php

declare(strict_types=1);

namespace App\Entity\User\DTO;

use App\Entity\DataTransferObject;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert; // Symfony's built-in constraints
use Symfony\Component\Validator\Constraints\DateTime; // serialization groups



/**
 * The most generic type of item.
 *
 * @see http://schema.org/Person Documentation on Schema.org
 *
 * @ApiResource(
 *     routePrefix="/user",
 *     itemOperations={
 *        "getUser" = {
 *              "method"="GET",
 *              "path"="/{id}" ,
 *              "denormalization_context"={"groups"={"read"} },
 *              "normalization_context"={"groups"={"read"} }
 *          },
 *     },
 *     collectionOperations={
 *         "postUser" = {
 *              "method"="POST",
 *              "path"="/" ,
 *              "denormalization_context"={"groups"={"write"} },
 *              "normalization_context"={"groups"={"write"} }
 *          },
 *     },
 * )
 */
final class UserDTO extends DataTransferObject
{

    /**
     * @var string|null
     *
     * @ApiProperty(identifier=true)
     * @Groups({"read", "appCommon"})
     * @Assert\NotBlank(groups={"GetUser"})
     */
    public $id;

    /**
     * @var string|null
     *
     * @Groups({"read"})
     * @Assert\NotBlank(groups={"GetUser"})
     */
    public $createdAt;

    /**
     *
     * @var string|null
     *
     * @Groups({"read", "write", "appCommon"})
     * @Assert\NotBlank(groups={"PostUser","GetUser"})
     */
    public $username;

    /**
     * @var string|null
     *
     * @Groups({"write"})
     * @Assert\NotBlank(groups={"PostUser","GetUser"})
     */
    public $password;

    /**
     * @var string|null
     *
     * @Groups({"read", "write", "appCommon"})
     * @Assert\NotBlank(groups={"PostUser","GetUser"})
     */
    public $email;

    /**
     * @var string|null
     *
     * @Groups({"read", "write", "appCommon"})
     * @Assert\NotBlank(groups={"PostUser","GetUser"})
     */
    public $birthDate;

    /**
     * @var string|null
     *
     * @Groups({"read", "appCommon"})
     */
    public $userPicture;

    /**
     * @var string|null
     *
     * @Groups({"read", "appCommon"})
     */
    public $userClass;

    /**
     * @var string|null
     *
     * @Groups({"read", "appCommon"})
     */
    public $userSection;

    /**
     * @var array
     *
     * @Groups({"read", "appCommon"})
     */
    public $successDTOs;

    /**
     * @var array
     *
     * @Groups({"read", "appCommon"})
     */
    public $pictureDTOs;

    /**
     * @var array
     *
     * @Groups({"read", "appCommon"})
     */
    public $preferredPartnerDTOs;

    /**
     * @var array
     *
     * @Groups({"read", "appCommon"})
     */
    public $disponibilityPatterns;

}

