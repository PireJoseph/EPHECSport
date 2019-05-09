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

/**
 * @ApiResource(
 *     itemOperations={
 *           "getSportProfile" = {
 *              "method"="Get",
 *              "path"="/sportprofiles/{id}",
 *              "denormalization_context"={"groups"={"read"} },
 *              "normalization_context"={"groups"={"read"} }
 *         },
 *     },
 *     collectionOperations={
 *          "submitSportProfile" = {
 *              "method"="POST",
 *              "path"="/sportprofiles/",
 *              "denormalization_context"={"groups"={"write"} },
 *              "normalization_context"={"groups"={"write"} }
 *         },
 *     },
 * )
 */
class SportProfileDTO
{

    /**
     * @Groups({"write", "read"})
     * @ApiProperty(identifier=true)
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

    public $sportClubDTO;

    /**
     * @Groups({"write","read"})
     */
    public $sportId;
    /**
     * @Groups({"read","read"})
     */
    public $sportDTO;



    public function getId()
    {
        return $this->id;
    }



}