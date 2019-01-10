<?php

declare(strict_types=1);

namespace App\Entity\User\DTO;

use App\Entity\DataTransferObject;
use Symfony\Component\Validator\Constraints as Assert; // Symfony's built-in constraints
use Symfony\Component\Validator\Constraints\DateTime; // serialization groups



/**
 * The most generic type of item.
 *
 * @see http://schema.org/Person Documentation on Schema.org
 *
 */
final class UserDTO extends DataTransferObject
{

    /**
     *
     * @var string|null
     *
     * @Assert\NotBlank(groups={"createUser"})
     */
    public $username;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(groups={"createUser"})
     */
    public $password;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(groups={"createUser"})
     */
    public $email;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(groups={"createUser"})*
     */
    public $birthDate;
}
