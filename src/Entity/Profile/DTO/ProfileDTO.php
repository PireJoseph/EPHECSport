<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 1/05/19
 * Time: 8:28
 */

namespace App\Entity\Profile\DTO;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\Actions\Profile\RemovePreferredPartner;
use App\Controller\Actions\Profile\AddPreferredPartner;

/**
 * @ApiResource(
 *     itemOperations={
 *        "getProfile" = {
 *              "method"="GET",
 *              "path"="/profile/{id}" ,
 *               "denormalization_context"={"groups"={"read"} },
 *              "normalization_context"={"groups"={"read"} }
 *          },
 *        "updateProfile" = {
 *              "method"="PUT",
 *              "path"="/profile/{id}",
 *              "denormalization_context"={"groups"={"write"} },
 *              "normalization_context"={"groups"={"write"} }
 *         },
 *        "addPreferredPartner" = {
 *              "method"="PUT",
 *              "path"="/profile/{id}/partner/add",
 *              "denormalization_context"={"groups"={"partner"} },
 *              "normalization_context"={"groups"={"partner"} },
 *              "controller"=AddPreferredPartner::class,
 *         },
 *        "removePreferredPartner" = {
 *              "method"="PUT",
 *              "path"="/profile/{id}/partner/remove",
 *              "denormalization_context"={"groups"={"partner"} },
 *              "normalization_context"={"groups"={"partner"} },
 *              "controller"=RemovePreferredPartner::class,
 *         },
 *     },
 *     collectionOperations={
 *        "getOtherProfiles" = {
 *              "method"="GET",
 *              "path"="/profile/",
 *              "denormalization_context"={"groups"={"all"} },
 *              "normalization_context"={"groups"={"all"} }
 *         },
 *     },
 * )
 */
class ProfileDTO
{

    /**
     * the id of the connected user
     * @var string|null
     * @ApiProperty(identifier=true)
     */
    public $id;
    /**
    * @Groups({"write", "read", "all"})
    */
    public $username;
    /**
     * @Groups({"write"})
     */
    public $newPassword;
    /**
     * @Groups({"write"})
     */
    public $areSuccessUnlockedVisible;
    /**
     * @Groups({"write"})
     */
    public $areActivityParticipationVisible;
    /**
     * @Groups({"write"})
     */
    public $isPersonalProfileVisible;
    /**
     * @Groups({"write", "read", "all"})
     */
    public $picture;
    /**
     * @Groups({"write"})
     */
    public $pictureFile;
    /**
     * @Groups({"write"})
     */
    public $pictureName;
    /**
     * @Groups({"write", "read", "all"})
     */
    public $description;
    /**
     * @Groups({"write", "read", "all"})
     */
    public $email;
    /**
     * @Groups({"write"})
     */
    public $phoneNumber;

    /**
     * @Groups({"write", "read", "all"})
     */
    public $gender;
    /**
     * @Groups({"write", "read", "all"})
     */
    public $birthDate;
    /**
     * @Groups({"write", "read", "all"})
     */
    public $pictures;
    /**
     * @Groups({"write", "read", "all"})
     */
    public $schoolClass;

    /**
     * @Groups({"write", "read", "all"})
     */
    public $canGoAway;
    /**
     * @Groups({"write"})
     */
    public $activityCostLimit;
    /**
     * @Groups({"write", "read", "all"})
     */
    public $disponibilityPatterns;
    /**
     * @Groups({"write"})
     */
    public $preferredPartnerIds;

    /**
     * @Groups({"all"})
     */
    public $isMyPartner;

    /**
     * @Groups({"partner"})
     */
    public $preferredPartnerId;

}