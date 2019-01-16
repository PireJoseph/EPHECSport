<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 28/12/18
 * Time: 0:56
 */

namespace App\Managers\User;

use ApiPlatform\Core\Validator\Exception\ValidationException;
use App\Assemblers\User\DTO\UserDTOAssembler;
use App\Assemblers\User\UserAssembler;
use App\Entity\User\DTO\UserDTO;
use App\Entity\User\User;
use App\Security\iHasRole;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserManager
{
    private $userAssembler;
    private $userDTOAssembler;
    private $validator;
    private $em;
    private $passwordEncoder;


    public function __construct(ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder, UserAssembler $userAssembler, UserDTOAssembler $userDTOAssembler, EntityManagerInterface $entityManager)
    {
        $this->validator = $validator;
        $this->em = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->userAssembler = $userAssembler;
        $this->userDTOAssembler = $userDTOAssembler;
    }


    /**
     * @param UserDTO $userDTO
     * @return UserDTO
     * @throws Exception
     */
    public function
    createUserFromDTO(UserDTO $userDTO)
    {
        // request validation
        $userDTOValidation = $this->validator->validate($userDTO,null, ['PostUser']);
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

        //
        // Business logic -> assignation of roles and password encryption
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
        $now = new DateTime();
        $newUser->setCreatedAt($now);

        // validate the new user
        $newUserValidation = $this->validator->validate($newUser);
        if ($newUserValidation->count() > 0)
        {
            throw new ValidationException($newUserValidation);
        }

        $this->em->beginTransaction();
        try
        {
            // Création de la réponse JSON
            $newUserDTO = $this->userDTOAssembler->getFromUser($newUser);
            $newUserDTO->password = $userDTO->password; // ON RÉENOIE LE MDP EN CLAIR

            // sauvegarde du nouvel utilisateur
            $this->em->persist($newUser);
            $this->em->flush($newUser);

            // vérification de l'existance du nouvel utilisateur
            $persistedUser = $this->em->getRepository(User::class)->findOneBy(['username' => $newUserDTO->username]);
            if (is_null($persistedUser)) {
                throw new Exception('user persisted but not retrieved :hyperthonk:');
            }

            // création de la représentation du nouvel utilisateur

        }
        catch (Exception $e)
        {
            $this->em->rollback();
            throw $e;
        }
        $this->em->commit();

        return $newUserDTO;

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
     * @return User|null
     * @throws Exception
     */
    public function getUserDTO($id) : ? UserDTO
    {
        $user = $this->getUser($id);
        if (is_null($user)){
            throw new Exception('User does not exist');
        }

        $userDTO = $this->userDTOAssembler->getFromUser($user);

        return $userDTO;
    }


}