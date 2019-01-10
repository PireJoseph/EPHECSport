<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 28/12/18
 * Time: 0:56
 */

namespace App\Controller\APIManagers\User;

use ApiPlatform\Core\Validator\Exception\ValidationException;
use App\Controller\APIAssemblers\User\UserAssembler;
use App\Entity\User\DTO\UserDTO;
use App\Entity\User\User;
use App\Security\iHasRole;
use DateTime;
use Doctrine\Common\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserManager
{
    private $userAssembler;
    private $validator;
    private $em;
    private $passwordEncoder;


    public function __construct(ValidatorInterface $validator, ManagerRegistry $doctrine, UserPasswordEncoderInterface $passwordEncoder, UserAssembler $userAssembler)
    {
        $this->validator = $validator;
        $this->em = $doctrine->getManager();
        $this->passwordEncoder = $passwordEncoder;
        $this->userAssembler = $userAssembler;
    }


    /**
     * @param UserDTO $userDTO
     * @return UserDTO
     * @throws Exception
     */
    public function createUserFromDTO(UserDTO $userDTO)
    {
        // request validation
        $userDTOValidation = $this->validator->validate($userDTO);
        if ($userDTOValidation->count() > 0)
        {
            throw new ValidationException($userDTOValidation);
        }

        // vérifier si un utilisateur existe déja
        $alreadyExistingUser = $this->em->getRepository(User::class)->findOneByUsername($userDTO->username);

        if (!is_null($alreadyExistingUser))
        {
            // TODO implement exception
            throw new Exception('User already exist');
        }

        // récupération d'une entité utilisateur
        $newUser = $this->userAssembler->getFromUserDTO($userDTO);

        // sauvegarde du nouvel utilisateur
        $this->em->persist($newUser);
        $this->em->flush($newUser);

        //TODO envoi de mail de validation

        $plainTextPassword = $userDTO->password;

        $persistedUserDTO = $this->userAssembler->getUserDTOFromUser($newUser, $plainTextPassword);

        return $persistedUserDTO;


    }

    /**
     * @param $id
     * @return User|Null
     * @throws Exception
     */
    public function getUser($id) : ? User
    {
        if (is_null($id))
        {
            // TODO implement exception
            throw new Exception('User id is missing');
        }
        $user = $this->em->getRepository(User::class)->find($id);
        if (is_null($user))
        {
            // TODO implement exception
            throw new Exception('User does not exist');
        }
        return $user;
    }


    /**
     * @param $id
     * @return UserDTO|null
     * @throws Exception
     */
    public function getUserDTO($id)
    {
            $user = $this->getUser($id);

            if(is_null($user)) {
                return null;
            }

             return $this->userAssembler->getUserDTOFromUser($user);

    }

    /**
     * @param UserDTO $userDTO
     * @return UserDTO|Exception
     * @throws Exception
     */
    public function getUserFromDTO(UserDTO $userDTO)
    {
        // request validation
        $userDTOValidation = $this->validator->validate($userDTO);
        if ($userDTOValidation->count() > 0)
        {
            throw new ValidationException($userDTOValidation);
        }

        // vérifier si un utilisateur existe déja
        $alreadyExistingUser = $this->em->getRepository(User::class)->findOneByUsername($userDTO->username);
        if (!is_null($alreadyExistingUser))
        {
            // TODO implement exception
            throw new Exception('User already exist');
        }

        $alreadyExistingUserDTO = $this->userAssembler->getUserDTOFromUser($alreadyExistingUser);
        return $alreadyExistingUserDTO;
    }



}