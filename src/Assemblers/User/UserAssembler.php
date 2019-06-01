<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 27/12/18
 * Time: 21:43
 */

namespace App\Assemblers\User;


use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use App\Entity\User\DTO\UserDTO;
use App\Entity\User\User;
use App\Security\iHasRole;
use DateTime;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserAssembler
{
    private $passwordEncoder;
    private $validator;

    /**
     * UserAssembler constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param ValidatorInterface $validator
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, ValidatorInterface $validator)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->validator = $validator;
    }

    /**
     * @param UserDTO $userDTO
     * @return User|null
     * @throws \Exception
     */
    public function getFromUserDTO(UserDTO $userDTO) : User
    {
        //TODO REFACTO, PAS DE BUSINEESS LOGIC GENRE PASSAGE DE ROLE
        $userDTOValidation = $this->validator->validate($userDTO);
        if ($userDTOValidation->count() > 0)
        {
            throw new ValidationException($userDTOValidation);
        }




        $newUser = new User();
        $newUser->setUsername($userDTO->username);
        $newUser->setEmail($userDTO->email);

        // 'Age'
        $birthDate = new DateTime($userDTO->birthDate);
        $newUser->setBirthDate($birthDate);

        //  rôles
        $newUserRoles = array(iHasRole::ROLE_USER);
        $newUser->setRoles($newUserRoles);

        // mot de passe
        $newUser->setPassword($this->passwordEncoder->encodePassword(
            $newUser,
            $userDTO->password
        ));

        // date de creation
        $createdAtDateTimeConstructorParam = is_null($userDTO->createdAt) ? '' : $userDTO->createdAt;
        $createdAtDateTime = new DateTime($createdAtDateTimeConstructorParam);
        $newUser->setCreatedAt($createdAtDateTime);


        // validate the new user
        $newUserValidation = $this->validator->validate($newUser);
        if ($newUserValidation->count() > 0)
        {
            throw new ValidationException($newUserValidation);
        }

        return $newUser;

    }

    /**
     * @param User $user
     * @param string|null $plainTextPassWord
     * @return UserDTO|\Exception
     */
    public function getUserDTOFromUser(User $user, string $plainTextPassWord = null): UserDTO
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
        $newUserDTO->createdAt = $user->getCreatedAt();

        // 'Age'
        $userBirthDate = $user->getBirthDate();
        $newUserDTO->birthDate = (!is_null($userBirthDate)) ? $userBirthDate->getTimestamp() : null;

        // Password
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