<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 8/05/19
 * Time: 20:19
 */

namespace App\Entity\Profile\DTO;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\Actions\Profile\CreateSportProfile;

/**
 *
 * @see http://schema.org/Thing Documentation on Schema.org
 *
 * @ApiResource(
 *     itemOperations={
 *           "getSportProfile" = {
 *              "method"="GET",
 *         },
 *        "updateSportProfile" = {
 *              "method"="PUT",
 *              "path"="/sportprofiles/{id}",
 *              "denormalization_context"={"groups"={"write"} },
 *              "normalization_context"={"groups"={"write"} }
 *         },
 *     },
 *     collectionOperations={
 *          "submitSportProfile" = {
 *              "method"="POST",
 *              "path"="/sportprofiles/",
 *              "denormalization_context"={"groups"={"write"} },
 *              "normalization_context"={"groups"={"write"} },
 *              "controller"=CreateSportProfile::class,
 *         },
 *     },
 * )
 */
class SportProfileDTO
{

    /**
     * @Groups({"write", "read"})
     * @ApiProperty(identifier=true, iri="https://schema.org/identifier", )
     */
    public $id;

    /**
     * @Groups({"write","read"})
     */
    public $role;
    /**
     * @Groups({"write","read"})
     */
    public $level;
    /**
     * @Groups({"write","read"})
     */
    public $isAimingFun;
    /**
     * @Groups({"write","read"})
     */
    public $isAimingPerf;
    /**
     * @Groups({"write","read"})
     */
    public $wantedTimesPerWeek;
    /**
     * @Groups({"write","read"})
     */
    public $wantToBeNotifiedAboutThisSport;
    /**
     * @Groups({"write","read"})
     */
    public $isVisible;

    /**
     * @Groups({"write"})
     */
    public $sportId;
    /**
     * @Groups({"read"})
     */
    public $sportDTO;




}