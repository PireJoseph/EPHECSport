<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 26/04/19
 * Time: 17:30
 */

namespace App\Entity\Activity\DTO;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;

class SportDTO
{
    /**
     * @ApiProperty(identifier=true)
     */
    public $id;

    public $label;
    
}