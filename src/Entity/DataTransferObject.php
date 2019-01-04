<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert; // Symfony's built-in constraints
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * The most generic type of item.
 *
 * @see http://schema.org/Thing Documentation on Schema.org
 *
 */
abstract class DataTransferObject
{
    /**
     * @var string|null
     *
     * @ApiProperty(identifier=true)
     * @Groups({"read"})
     */
    public $id;

    /**
     * @var string|null
     *
     * @Groups({"read"})
     */
    public $createdAt;
}
