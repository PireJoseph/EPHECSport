<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 2/03/19
 * Time: 20:39
 */

namespace App\Entity\User\DTO;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Email; // Symfony's built-in constraints

class RegisterFormDTO
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Votre nom utilisateur doit faire au moins {{ limit }} charactères",
     *      maxMessage = "Votre nom utilisateur doit faire maximum {{ limit }} charactères"
     * )
     */
    public  $userName;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 6,
     *      max = 4096,
     *      minMessage = "Votre nom utilisateur doit faire au moins {{ limit }} charactères",
     *      maxMessage = "Votre nom utilisateur doit faire maximum {{ limit }} charactères"
     * )
     */
    public $plainTextPassword;

    /**
     * @var Email
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $email;

    /**
     * @var Date
     *
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    public $birthDate;

}