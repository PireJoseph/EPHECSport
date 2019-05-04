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

/**
 * @ApiResource(
 *     itemOperations={
 *        "getProfile" = {
 *              "method"="GET",
 *              "path"="/profile/{id}" ,
 *          },
 *        "updateProfile" = {
 *              "method"="PUT",
 *              "path"="/profile/{id}",
 *         },
 *     },
 *     collectionOperations={},
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

    public $username;

}