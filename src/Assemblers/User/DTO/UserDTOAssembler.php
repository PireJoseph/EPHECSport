<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 10/01/19
 * Time: 1:24
 */

namespace App\Assemblers\User\DTO;


use ApiPlatform\Core\Validator\Exception\ValidationException;
use App\Entity\User\DTO\UserDTO;
use App\Entity\User\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserDTOAssembler
{

    private $passwordEncoder;
    private $validator;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, ValidatorInterface $validator)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->validator = $validator;
    }

    /**
     * @param User $user
     * @param string|NULL $plainTextPassWord
     * @return UserDTO
     */
    public function getFromUser(User $user, string $plainTextPassWord = NULL): UserDTO
    {

        if (count($errors = $this->validator->validate($user)))
        {
            throw new ValidationException($errors);
        }

        $userValidation = $this->validator->validate($user);
        if ($userValidation->count() > 0)
        {
            throw new ValidationException($userValidation);
        }

        $newUserDTO = new UserDTO();
        $newUserDTO->id = $user->getId();
        $newUserDTO->username = $user->getUsername();
        $newUserDTO->email = $user->getEmail();

        $userCreatedAt = $user->getCreatedAt();
        $newUserDTO->createdAt =  (!is_null($userCreatedAt)) ? $userCreatedAt->format('Y-m-d h:i:s') : null;

        // 'Age'
        $userBirthDate = $user->getBirthDate();
        $newUserDTO->birthDate = (!is_null($userBirthDate)) ? $userBirthDate->format('Y-m-d') : null;

        // Password --> we don't give it until its specified in the method
        $newUserDTO->password = $plainTextPassWord;

        if (count($errors = $this->validator->validate($newUserDTO)))
        {
            throw new ValidationException($errors);
        }

        $newUserDTOValidation = $this->validator->validate($newUserDTO);
        if ($newUserDTOValidation->count() > 0)
        {
            throw new ValidationException($newUserDTOValidation);
        }

        return $newUserDTO;
    }


}