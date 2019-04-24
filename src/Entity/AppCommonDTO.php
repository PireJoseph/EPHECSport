<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * @ApiResource(
 *     itemOperations={
 *        "getAppCommon" = {
 *              "method"="GET",
 *              "path"="/app/{id}" ,
 *          },
 *     },
 *     collectionOperations={},
 * )
 */
class AppCommonDTO
{

    /**
     * the id of the connected user
     * @var string|null
     * @ApiProperty(identifier=true)
     */
    public $id;


    public $userDTO;



}
