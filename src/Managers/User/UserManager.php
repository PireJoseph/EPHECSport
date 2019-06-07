<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 28/12/18
 * Time: 0:56
 */

namespace App\Managers\User;

use App\Assemblers\Profile\DTO\ProfileDTOAssembler;
use App\Assemblers\Profile\DTO\SportProfileDTOAssembler;
use App\Entity\Activity\ActivityCancellation;
use App\Entity\Activity\ActivityInvitation;
use App\Entity\Activity\ActivityParticipation;
use App\Entity\Activity\ActivityRelatedFeedback;
use App\Entity\Activity\Sport;
use App\Entity\Activity\UserRelatedFeedback;
use App\Entity\Profile\DTO\ProfileDTO;
use App\Entity\Profile\DTO\SportProfileDTO;
use App\Entity\Profile\SportProfile;
use App\Entity\Profile\Success;
use App\Entity\Promotion\ShoutOut;
use App\Exception\EmailAddressAlreadyExistsException;
use App\Exception\InvalidArgumentException;
use App\Exception\InvalidIdentifierException;
use App\Exception\ItemNotFoundException;
use App\Exception\ValidationException;
use App\Exception\itemAlreadyExistsException;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use App\Assemblers\User\DTO\UserDTOAssembler;
use App\Assemblers\User\UserAssembler;
use App\Entity\User\DTO\UserDTO;
use App\Entity\User\User;
use App\Security\iHasRole;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserManager
{
    private $userAssembler;
    private $userDTOAssembler;
    private $validator;
    private $em;
    private $passwordEncoder;
    private $profileDTOAssembler;
    private $sportProfileDTOAssembler;
    private $security;


    public function __construct(Security $security,ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder, UserAssembler $userAssembler, UserDTOAssembler $userDTOAssembler, EntityManagerInterface $entityManager, ProfileDTOAssembler $profileDTOAssembler, SportProfileDTOAssembler $sportProfileDTOAssembler)
    {
        $this->security = $security;
        $this->validator = $validator;
        $this->em = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->userAssembler = $userAssembler;
        $this->userDTOAssembler = $userDTOAssembler;
        $this->profileDTOAssembler = $profileDTOAssembler;
        $this->sportProfileDTOAssembler = $sportProfileDTOAssembler;
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
                throw new Exception('user persisted but not retrieved');
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
     * @throws ValidationException
     * @throws Exception
     */
    public function updateProfileFromDTO(ProfileDTO $profileDTO)
    {

        $id = $profileDTO->id;
        $alreadyExistingUser = $this->getUser($id);

        //
        // Restricting access
        if (is_null($this->security->getToken())|| is_null($this->security->getToken()->getUser()||$this->security->getToken()->getUser()->getId()))
        {
            throw new AccessDeniedException('Restricted area');
        }
        $connectedUser = $this->security->getToken()->getUser();
        $connectedUserId = $connectedUser->getId();
        $profileDTOid = $profileDTO->id;
        if($connectedUserId !== $profileDTOid)
        {
            //on ne peut modifier que sont profil
            throw new AccessDeniedException('Restricted area');
        }

        //
        // Updating Fields Following form
        $username = $profileDTO->username;
        $alreadyExistingUser->setUsername($username);

        // updating password
        $newPassword= $profileDTO->newPassword;
        if(!is_null($newPassword)) {
            $encodedNewPassword = $this->passwordEncoder->encodePassword(
                $alreadyExistingUser,
                $newPassword
            );
            $alreadyExistingUser->setPassword($encodedNewPassword);
        }

        $areSuccessUnlockedVisible = $profileDTO->areSuccessUnlockedVisible;
        if(!is_null($areSuccessUnlockedVisible))
        {
            $alreadyExistingUser->setAreSuccessUnlockedVisible($areSuccessUnlockedVisible);
        }

        $areActivityParticipationVisible = $profileDTO->areActivityParticipationVisible;
        if(!is_null($areActivityParticipationVisible)){
            $alreadyExistingUser->setAreActivityParticipationVisible($areActivityParticipationVisible);
        }

        $isPersonalProfileVisible = $profileDTO->isPersonalProfileVisible;
        if(!is_null($isPersonalProfileVisible)){
            $alreadyExistingUser->setIsPersonalProfileVisible($isPersonalProfileVisible);
        }

        $description = $profileDTO->description;
        if(!is_null($description)){
            $alreadyExistingUser->setDescription($description);
        }

        $email = $profileDTO->email;
        if(!is_null($email)){
            $alreadyExistingUser->setEmail($email);
        }

        $phoneNumber = $profileDTO->phoneNumber;
        if(!is_null($phoneNumber)){
            $alreadyExistingUser->setPhoneNumber($phoneNumber);
        }

        $gender = $profileDTO->gender;
        if(!is_null($gender)){
            $alreadyExistingUser->setGender($gender);
        }

        $birthDate = $profileDTO->birthDate;
        if(!is_null($birthDate)){
            $birthDateDateTime = new DateTime($birthDate);
            $alreadyExistingUser->setBirthDate($birthDateDateTime);
        }

        $canGoAway = $profileDTO->canGoAway;
        if(!is_null($canGoAway)){
            $alreadyExistingUser->setCanGoAway($canGoAway);
        }

        $activityCostLimit = $profileDTO->activityCostLimit;
        if(!is_null($activityCostLimit)){
            $alreadyExistingUser->setActivityCostLimit($activityCostLimit);
        }

        $disponibilityPatterns = $profileDTO->disponibilityPatterns;
        if(!is_null($disponibilityPatterns)){
            $alreadyExistingUser->setDisponibilityPatterns($disponibilityPatterns);
        }

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
            $newProfileDTO = $this->profileDTOAssembler->getFromUser($alreadyExistingUser, $connectedUser);

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



    public function getOtherProfiles() :  array
    {

        //
        // Restricting access
        if (is_null($this->security->getToken())|| is_null($this->security->getToken()->getUser()))
        {
            throw new AccessDeniedException('Restricted area');
        }

        /**  @var User $connectedUser */
        $connectedUser = $this->security->getToken()->getUser();

        $profileDTOs = [];

        $usersArray = $this->em->getRepository(User::Class)->getOthers($connectedUser->getId());

        foreach ($usersArray as $user)
        {
            $profileDTO = $this->profileDTOAssembler->getFromUser($user, $connectedUser);
            $profileDTOs[] = $profileDTO;
        }

        return $profileDTOs;
    }

    /**
     * @param SportProfileDTO $sportProfileDTO
     */
    public function updateSportProfileFromDTO(SportProfileDTO $sportProfileDTO)
    {

        //
        // Restricting access
        if (is_null($this->security->getToken())|| is_null($this->security->getToken()->getUser()||$this->security->getToken()->getUser()->getId()))
        {
            throw new AccessDeniedException('Restricted area');
        }
        $connectedUser = $this->security->getToken()->getUser();
        $connectedUserId = $connectedUser->getId();
        $sportId = $sportProfileDTO->sportId;


        $existingSportProfileQueryResult =  $this->em->getRepository(SportProfile::class)->findOneBy(['user' => $connectedUserId, 'sport' => $sportId]);

        $sport = $this->em->getRepository(Sport::class)->find($sportId);

        $newSportProfile = new SportProfile();
        $newSportProfile->setUser($connectedUser);
        $newSportProfile->setSport($sport);
        $newSportProfile->setLevel($sportProfileDTO->level);
        $newSportProfile->setRole($sportProfileDTO->role);
        if(!is_null($sportProfileDTO->isAimingFun))
        {
            $newSportProfile->setIsAimingFun($sportProfileDTO->isAimingFun);
        }
        else
        {
            $newSportProfile->setIsAimingFun(TRUE);
        }
        if(!is_null($sportProfileDTO->isAimingPerf))
        {
            $newSportProfile->setIsAimingPerf($sportProfileDTO->isAimingPerf);
        }
        else
        {
            $newSportProfile->setIsAimingPerf(TRUE);

        }
        if(!is_null($sportProfileDTO->isVisible))
        {
            $newSportProfile->setIsVisible($sportProfileDTO->isVisible);
        }
        else
        {
            $newSportProfile->setIsVisible(FALSE);
        }
        if(!is_null($sportProfileDTO->wantedTimesPerWeek))
        {
            $newSportProfile->setWantedTimesPerWeek($sportProfileDTO->wantedTimesPerWeek);
        }
        if(!is_null($sportProfileDTO->wantToBeNotifiedAboutThisSport))
        {
            $newSportProfile->setWantToBeNotifiedAboutThisSport($sportProfileDTO->wantToBeNotifiedAboutThisSport);
        }

        try
        {

            // suppression de l'ancien sport profil
            if (!is_null($existingSportProfileQueryResult))
            {
                $this->em->remove($existingSportProfileQueryResult);
                $this->em->flush();
            }

            // validate the sport profile
            $newSportProfileValidation = $this->validator->validate($newSportProfile);
            if ($newSportProfileValidation->count() > 0)
            {
                if (!is_null($existingSportProfileQueryResult))
                {
                    $this->em->persist($existingSportProfileQueryResult);
                    $this->em->flush();
                }
                throw new ValidationException($newSportProfileValidation);
            }

            // sauvegarde du nouveau sport profile
            $this->em->persist($newSportProfile);
            $this->em->flush();

            // Création de la réponse JSON
            $newSportProfileProfileDTO = $this->sportProfileDTOAssembler->getFromSportProfileForAppCommon($newSportProfile);

        }
        catch (Exception $e)
        {
            throw $e;
        }

        return $newSportProfileProfileDTO;

    }

    /**
     * @param SportProfileDTO $sportProfileDTO
     * @return SportProfileDTO
     * @throws itemAlreadyExistsException
     */
    public function createSportProfileFromDTO(SportProfileDTO $sportProfileDTO)
    {
        //
        // Restricting access
        if (is_null($this->security->getToken())|| is_null($this->security->getToken()->getUser()||$this->security->getToken()->getUser()->getId()))
        {
            throw new AccessDeniedException('Restricted area');
        }
        $connectedUser = $this->security->getToken()->getUser();
        $connectedUserId = $connectedUser->getId();
        $sportId = $sportProfileDTO->sportId;

        $existingSportProfileQueryResult =  $this->em->getRepository(SportProfile::class)->findOneBy(['user' => $connectedUserId, 'sport' => $sportId]);
        if(!is_null($existingSportProfileQueryResult))
        {
            throw new itemAlreadyExistsException('Profil sportif existant');
        }

        $sport = $this->em->getRepository(Sport::class)->find($sportId);

        $newSportProfile = new SportProfile();
        $newSportProfile->setUser($connectedUser);
        $newSportProfile->setSport($sport);
        $newSportProfile->setLevel($sportProfileDTO->level);
        $newSportProfile->setRole($sportProfileDTO->role);
        if(!is_null($sportProfileDTO->isAimingFun))
        {
            $newSportProfile->setIsAimingFun($sportProfileDTO->isAimingFun);
        }
        else
        {
            $newSportProfile->setIsAimingFun(TRUE);
        }
        if(!is_null($sportProfileDTO->isAimingPerf))
        {
            $newSportProfile->setIsAimingPerf($sportProfileDTO->isAimingPerf);
        }
        else
        {
            $newSportProfile->setIsAimingPerf(TRUE);

        }
        if(!is_null($sportProfileDTO->isVisible))
        {
            $newSportProfile->setIsVisible($sportProfileDTO->isVisible);
        }
        else
        {
            $newSportProfile->setIsVisible(FALSE);
        }
        if(!is_null($sportProfileDTO->wantedTimesPerWeek))
        {
            $newSportProfile->setWantedTimesPerWeek($sportProfileDTO->wantedTimesPerWeek);
        }
        if(!is_null($sportProfileDTO->wantToBeNotifiedAboutThisSport))
        {
            $newSportProfile->setWantToBeNotifiedAboutThisSport($sportProfileDTO->wantToBeNotifiedAboutThisSport);
        }

        try
        {

            // validate the sport profile
            $newSportProfileValidation = $this->validator->validate($newSportProfile);
            if ($newSportProfileValidation->count() > 0)
            {
                throw new ValidationException($newSportProfileValidation);
            }

            // sauvegarde du nouveau sport profile
            $this->em->persist($newSportProfile);
            $this->em->flush();

            // Création de la réponse JSON
            $newSportProfileProfileDTO = $this->sportProfileDTOAssembler->getFromSportProfileForAppCommon($newSportProfile);

        }
        catch (Exception $e)
        {
            throw $e;
        }

        return $newSportProfileProfileDTO;


    }

    /**
     * @param $id
     * @return object|null
     */
    public function getSportProfile($id){

        $sportProfile = $this->em->getRepository(SportProfile::class)->findOneBy(['id' => $id]);
        return $sportProfile;

    }

    /**
     * @param ProfileDTO $data
     * @return ProfileDTO
     * @throws Exception
     */
    public function addPreferredPartner(ProfileDTO $data)
    {

        $preferredPartnerId = $data->preferredPartnerId;
        $providedUserId = $data->id;

        //
        // Restricting access
        if (is_null($this->security->getToken())|| is_null($this->security->getToken()->getUser()||$this->security->getToken()->getUser()->getId()))
        {
            throw new AccessDeniedException('Restricted area');
        }
        $connectedUser = $this->security->getToken()->getUser();
        $connectedUserId = $connectedUser->getId();
        if($connectedUserId !== $providedUserId)
        {
            //on ne peut modifier que sont profil
            throw new AccessDeniedException('Restricted area');
        }

        /** @var User $preferredPartner */
        $preferredPartner = $this->em->getRepository(User::class)->find($preferredPartnerId);
        /** @var User $userToModify */
        $userToModify = $this->em->getRepository(User::class)->find($providedUserId);

        if(is_null($preferredPartner) || is_null($userToModify))
        {
            throw new ItemNotFoundException('User not found');
        }

        if (!$userToModify->getPreferredPartners()->contains($preferredPartner))
        {
            $userToModify->getPreferredPartners()->add($preferredPartner);
        }

        $this->em->persist($userToModify);
        $this->em->flush();

        return $data;
    }


    /**
     * @param ProfileDTO $data
     * @return ProfileDTO
     * @throws Exception
     */
    public function removePreferredPartner(ProfileDTO $data)
    {

        $preferredPartnerId = $data->preferredPartnerId;
        $providedUserId = $data->id;

        //
        // Restricting access
        if (is_null($this->security->getToken())|| is_null($this->security->getToken()->getUser()||$this->security->getToken()->getUser()->getId()))
        {
            throw new AccessDeniedException('Restricted area');
        }
        $connectedUser = $this->security->getToken()->getUser();
        $connectedUserId = $connectedUser->getId();
        if($connectedUserId !== $providedUserId)
        {
            //on ne peut modifier que sont profil
            throw new AccessDeniedException('Restricted area');
        }

        /** @var User $preferredPartner */
        $preferredPartner = $this->em->getRepository(User::class)->find($preferredPartnerId);
        /** @var User $userToModify */
        $userToModify = $this->em->getRepository(User::class)->find($providedUserId);

        if(is_null($preferredPartner) || is_null($userToModify))
        {
            throw new ItemNotFoundException('User not found');
        }

        if ($userToModify->getPreferredPartners()->contains($preferredPartner))
        {
            $userToModify->getPreferredPartners()->removeElement($preferredPartner);
        }

        $this->em->persist($userToModify);
        $this->em->flush();

        return $data;
    }

    /**
     * delete user related data before deleting user
     * @param User $user
     * @return User
     * @throws InvalidArgumentException
     */
    public function deleteUserData(User $user){

        if (is_null($user) || (!$user instanceof User)) {
            throw new InvalidArgumentException('you need to provide a user in order to delete his account');
        }

        // suppression des photo utilisateurs
        $pictures = $user->getPictures();
        foreach($pictures as $picture){
            $this->em->remove($picture);
        }
        $user->setPictures(new ArrayCollection());


        $profilePicture  = $user->getProfilePicture();
        if(!is_null($profilePicture)){
            $this->em->remove($profilePicture);
        }

        // sport profiles
        $sportProfilesQuerySelect = $this->em->getRepository(SportProfile::class)->findBy(['user'=>$user]);
        foreach ($sportProfilesQuerySelect as $sportProfile)
        {
            $this->em->remove($sportProfile);
        }

        // success
        $successQueryResult = $this->em->getRepository(Success::class)->findBy(['user'=>$user]);
        foreach ($successQueryResult as $success)
        {
            $this->em->remove($success);
        }

        // success
        $successQueryResult = $this->em->getRepository(Success::class)->findBy(['user'=>$user]);
        foreach ($successQueryResult as $success)
        {
            $this->em->remove($success);
        }

        // activity invitation
        $invitationsQueryResult = $this->em->getRepository(ActivityInvitation::class)->findBy(['recipitent'=>$user]);
        foreach ($invitationsQueryResult as $success)
        {
            $this->em->remove($success);
        }

        // activity participation
        $participationQueryResult = $this->em->getRepository(ActivityParticipation::class)->findBy(['user'=>$user]);
        foreach ($participationQueryResult as $participation)
        {
            $this->em->remove($participation);
        }

        //userRelatedFeedback
        $userFeedBackMadeQueryResult = $this->em->getRepository(UserRelatedFeedback::class)->findBy(['createdBy'=>$user]);
        foreach ($userFeedBackMadeQueryResult as $feedbackMade)
        {
            $this->em->remove($feedbackMade);
        }
        $userFeedBackAddressedQueryResult = $this->em->getRepository(UserRelatedFeedback::class)->findBy(['user'=>$user]);
        foreach ($userFeedBackAddressedQueryResult as $feedbackAddressed)
        {
            $this->em->remove($feedbackAddressed);
        }

        //activity cancellation
        $activityCancellationQueryResult = $this->em->getRepository(ActivityCancellation::class)->findBy(['createdBy'=>$user]);
        foreach ($activityCancellationQueryResult as $cancellation)
        {
            $this->em->remove($cancellation);
        }

        //activity related feedback
        $activityRelatedFeedbackCreatedQueryResult = $this->em->getRepository(ActivityRelatedFeedback::class)->findBy(['createdBy'=>$user]);
        foreach ($activityRelatedFeedbackCreatedQueryResult as $feedbackCreated)
        {
            $this->em->remove($feedbackCreated);
        }
        $activityRelatedFeedbackMadeQueryResult = $this->em->getRepository(ActivityRelatedFeedback::class)->findBy(['author'=>$user]);
        foreach ($activityRelatedFeedbackMadeQueryResult as $feedbackMade)
        {
            $this->em->remove($feedbackMade);
        }

        // shoutouts
        $shoutOutsQueryResult = $this->em->getRepository(ShoutOut::class)->findBy(['createdBy'=>$user]);
        foreach ($shoutOutsQueryResult as $shoutOut)
        {
            $this->em->remove($shoutOut);
        }


        $this->em->flush();


        // suppression de la photo de profil
        return $user;

    }

    public function removeUser(User $user){
        $this->em->remove($user);
        $this->em->flush();
    }

    public function blockPersonalDataUsage() {
        //
        // Restricting access
        if (is_null($this->security->getToken())|| is_null($this->security->getToken()->getUser()||$this->security->getToken()->getUser()->getId()))
        {
            throw new AccessDeniedException('Restricted area');
        }
        /** @var User $connectedUser */
        $connectedUser = $this->security->getToken()->getUser();
    }

    public function getAllPersonalData(User $user) {


        $toSend = [];
        $toSend['utilisateur'] = $user;

        // succès
        $successQueryResult = $this->em->getRepository(Success::class)->findBy(['user' => $user]);
        $successArray = [];
        foreach ($successQueryResult as $success){
            $successArray[] = $success;
        }
        if(count($successArray)> 0) {
            $toSend['succès'] = $successArray;
        }

        return $toSend;



    }



}