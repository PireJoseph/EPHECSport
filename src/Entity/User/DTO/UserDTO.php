<?php

declare(strict_types=1);

namespace App\Entity\User\DTO;

use App\Entity\DataTransferObject;
use Symfony\Component\Validator\Constraints as Assert; // Symfony's built-in constraints
use Symfony\Component\Validator\Constraints\DateTime; // serialization groups
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;



/**

 *
 */
final class UserDTO extends DataTransferObject
{

    /**
     * @var string|null
     *
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
     * @Groups({"read", "write", "appCommon"})
     * @Assert\NotBlank(groups={"PostUser","GetUser"})
     */
    public $gender;

    /**
     * @var string|null
     *
     * @Groups({"read", "write", "appCommon"})
     */
    public $phoneNumber;

    /**
     * @var string|null
     *
     * @Groups({"read","write",  "appCommon"})
     */
    public $description;

    /**
     * @var string|null
     *
     * @Groups({"read", "appCommon"})
     */
    public $userPicture;

    /**
     * @var string|null
     *
     * @Groups({"read","write", "appCommon"})
     */
    public $areSuccessUnlockedVisible;

    /**
     * @var string|null
     *
     * @Groups({"read","write",  "appCommon"})
     */
    public $areActivityParticipationVisible;

    /**
     * @var string|null
     *
     * @Groups({"read","write", "appCommon"})
     */
    public $isPersonalProfileVisible;

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
    public $pictureDTOs;

    /**
     * @var string|null
     *
     * @Groups({"read","write", "appCommon"})
     */
    public $canGoAway;

    /**
     * @var string|null
     *
     * @Groups({"read","write", "appCommon"})
     */
    public $activityCostLimit;


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

    /**
     * @var array
     *
     * @Groups({"read", "appCommon"})
     */
    public $addressedUserRelatedFeedbackDTOs;

    /**
     * @var array
     *
     * @Groups({"read", "appCommon"})
     */
    public $addressedUserRelatedFeedbackLabelsCumuled;

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
    public $nextActivityParticipationDTO;

    /**
     * @var array
     *
     * @Groups({"read", "appCommon"})
     */
    public $nextCrucialMeetingDTO;

    /**
     * @var array
     *
     * @Groups({"read", "appCommon"})
     */
    public $sportProfileDTOs;

}

