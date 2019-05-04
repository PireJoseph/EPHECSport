<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 28/12/18
 * Time: 0:56
 */

namespace App\Managers\User;

use App\Assemblers\Profile\DTO\ProfileDTOAssembler;
use App\Entity\Profile\DTO\ProfileDTO;
use App\Entity\Profile\Success;
use App\Exception\EmailAddressAlreadyExistsException;
use App\Exception\InvalidIdentifierException;
use App\Exception\ItemNotFoundException;
use App\Exception\ValidationException;
use App\Exception\itemAlreadyExistsException;
use Exception;
use App\Assemblers\User\DTO\UserDTOAssembler;
use App\Assemblers\User\UserAssembler;
use App\Entity\User\DTO\UserDTO;
use App\Entity\User\User;
use App\Security\iHasRole;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserManager
{
    private $userAssembler;
    private $userDTOAssembler;
    private $validator;
    private $em;
    private $passwordEncoder;
    private $profileDTOAssembler;


    public function __construct(ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder, UserAssembler $userAssembler, UserDTOAssembler $userDTOAssembler, EntityManagerInterface $entityManager, ProfileDTOAssembler $profileDTOAssembler)
    {
        $this->validator = $validator;
        $this->em = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->userAssembler = $userAssembler;
        $this->userDTOAssembler = $userDTOAssembler;
        $this->profileDTOAssembler = $profileDTOAssembler;
    }


    /**
     * @param UserDTO $userDTO
     * @return UserDTO
     * @throws Exception
     */
    public function createUserFromDTO(UserDTO $userDTO)
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
            throw new itemAlreadyExistsException('User already exist');
        }

        $alreadyExistingUser = $this->em->getRepository(User::class)->findOneByEmail($userDTO->email);
        if (!is_null($alreadyExistingUser))
        {
            throw new EmailAddressAlreadyExistsException('L\'adresse mail spécifiée existe déja');
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
            throw new InvalidIdentifierException('User id is missing');
        }
        $user = $this->em->getRepository(User::class)->find($id);

        if (is_null($user))
        {
            throw new ItemNotFoundException('User does not exist');
        }

        return $user;

    }


    /**
     * @param $userName
     * @param $plainPassword
     * @param $email
     * @param DateTime $birthDate
     * @return User
     * @throws ValidationException
     * @throws itemAlreadyExistsException
     * @throws EmailAddressAlreadyExistsException
     */
    public function createUser($userName, $plainPassword, $email, $birthDate)
    {

        // vérifier si un utilisateur existe déja
        $alreadyExistingUser = $this->em->getRepository(User::class)->findOneByUsername($userName);
        if (!is_null($alreadyExistingUser))
        {
            throw new itemAlreadyExistsException('Le nom d\'utilisateur spécifié existe déja');
        }

        $alreadyExistingUser = $this->em->getRepository(User::class)->findOneByEmail($email);
        if (!is_null($alreadyExistingUser))
        {
            throw new EmailAddressAlreadyExistsException('L\'adresse mail spécifiée existe déja');
        }

        //
        // Business logic -> assignation of roles and password encryption
        $newUser = new User();
        $newUser->setUsername($userName);
        $newUser->setEmail($email);
        // 'Age'
        $newUser->setBirthDate($birthDate);
        //  rôles
        $newUserRoles = array(iHasRole::ROLE_USER);
        $newUser->setRoles($newUserRoles);
        // mot de passe
        $newUser->setPassword($this->passwordEncoder->encodePassword(
            $newUser,
            $plainPassword
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

        // sauvegarde du nouvel utilisateur
        $this->em->persist($newUser);
        $this->em->flush($newUser);

        return $newUser;
    }

    /**
     * @param ProfileDTO $profileDTO
     * @return ProfileDTO
     * @throws Exception
     */
    public function updateProfileFromDTO(ProfileDTO $profileDTO)
    {
        $id = $profileDTO->id;
        $username = $profileDTO->username;

        $alreadyExistingUser = $this->getUser($id);

        //
        // Updating Fields Following form
        $alreadyExistingUser->setUsername($username);

        // validate the new user
        $alreadyExistingUserValidation = $this->validator->validate($alreadyExistingUser);
        if ($alreadyExistingUserValidation->count() > 0)
        {
            throw new ValidationException($alreadyExistingUserValidation);
        }

        $this->em->beginTransaction();
        try
        {
            // Création de la réponse JSON
            $newProfileDTO = $this->profileDTOAssembler->getFromUser($alreadyExistingUser);

            // sauvegarde du nouvel utilisateur
            $this->em->persist($alreadyExistingUser);
            $this->em->flush($alreadyExistingUser);

        }
        catch (Exception $e)
        {
            $this->em->rollback();
            throw $e;
        }
        $this->em->commit();

        return $newProfileDTO;

    }

}