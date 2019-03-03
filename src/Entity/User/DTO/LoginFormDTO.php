<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 2/03/19
 * Time: 20:39
 */

namespace App\Entity\User\DTO;


use Symfony\Component\Validator\Constraints as Assert; // Symfony's built-in constraints

class LoginFormDTO
{
    /**
     *
     * @var string
     *
     * @Assert\NotBlank()
     */
    public  $userName;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    public $password;

    /**
     * @var boolean
     *
     */
    public $rememberMe;

}