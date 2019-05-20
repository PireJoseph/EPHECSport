<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 10/01/19
 * Time: 1:24
 */

namespace App\Assemblers\User\DTO;


use ApiPlatform\Core\Validator\Exception\ValidationException;
use App\Assemblers\Activity\DTO\ActivityParticipationDTOAssembler;
use App\Assemblers\Activity\DTO\MaterialDTOAssembler;
use App\Assemblers\Activity\DTO\SportClubDTOAssembler;
use App\Assemblers\Activity\DTO\UserRelatedFeedbackDTOAssembler;
use App\Assemblers\Profile\DTO\PictureDTOAssembler;
use App\Assemblers\Profile\DTO\SportProfileDTOAssembler;
use App\Assemblers\Profile\DTO\SuccessDTOAssembler;
use App\Assemblers\Promotion\DTO\CrucialMeetingDTOAssembler;
use App\Entity\Activity\ActivityCancellation;
use App\Entity\Activity\ActivityParticipation;
use App\Entity\Activity\DTO\ActivityParticipationDTO;
use App\Entity\Activity\UserRelatedFeedback;
use App\Entity\Profile\SportProfile;
use App\Entity\Profile\Success;
use App\Entity\Promotion\CrucialMeeting;
use App\Entity\User\DTO\PreferredPartnerDTO;
use App\Entity\User\DTO\UserDTO;
use App\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserDTOAssembler
{

    private $validator;
    private $container;
    private $em;
    private $successDTOAssembler;
    private $pictureDTOAssembler;
    private $preferredPartnerDTOAssembler;
    private $userRelatedFeedbackDTOAssembler;
    private $activityParticipationDTOAssembler;
    private $crucialMeetingDTOAssembler;
    private $sportProfileDTOAssembler;
    private $translator;

    public function __construct(
        ValidatorInterface $validator,
        ContainerInterface $container,
        EntityManagerInterface $em,
        SuccessDTOAssembler $successDTOAssembler,
        PictureDTOAssembler $pictureDTOAssembler,
        PreferredPartnerDTOAssembler $preferredPartnerDTOAssembler,
        TranslatorInterface $translator,
        UserRelatedFeedbackDTOAssembler $userRelatedFeedbackDTOAssembler,
        ActivityParticipationDTOAssembler $activityParticipationDTOAssembler,
        CrucialMeetingDTOAssembler $crucialMeetingDTOAssembler,
        SportProfileDTOAssembler $sportProfileDTOAssembler
    )
    {
        $this->validator = $validator;
        $this->container = $container;
        $this->em = $em;
        $this->successDTOAssembler = $successDTOAssembler;
        $this->pictureDTOAssembler = $pictureDTOAssembler;
        $this->preferredPartnerDTOAssembler = $preferredPartnerDTOAssembler;
        $this->translator = $translator;
        $this->userRelatedFeedbackDTOAssembler = $userRelatedFeedbackDTOAssembler;
        $this->activityParticipationDTOAssembler = $activityParticipationDTOAssembler;
        $this->crucialMeetingDTOAssembler = $crucialMeetingDTOAssembler;
        $this->sportProfileDTOAssembler = $sportProfileDTOAssembler;
    }

    /**
     * @param User $user
     * @param string|NULL $plainTextPassWord
     * @return UserDTO
     * @throws ValidationException
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
        $newUserDTO->phoneNumber = $user->getPhoneNumber();
        $newUserDTO->description = $user->getDescription();
        $newUserDTO->gender = $user->getGender();

        $userCreatedAt = $user->getCreatedAt();
        $newUserDTO->createdAt =  (!is_null($userCreatedAt)) ? $userCreatedAt->format('Y-m-d') : null;

        // 'Age'
        $userBirthDate = $user->getBirthDate();
        $newUserDTO->birthDate = (!is_null($userBirthDate)) ? $userBirthDate->format('Y-m-d') : null;

        // Password --> we don't give it until its specified in the method
        $newUserDTO->password = $plainTextPassWord;

        if(!is_null( $user->getProfilePicture() ))
        {
            $newUserDTO->userPicture = $this->container->getParameter('profile_picture.uri_prefix') . '/' . $user->getProfilePicture()->getPicture();
        }

        if(!is_null( $user->getSchoolClass())) {
            $newUserDTO->userClass = $user->getSchoolClass()->getLabel();
            if (!is_null($user->getSchoolClass()->getSchoolSection()))
            {
                $newUserDTO->userSection = $user->getSchoolClass()->getSchoolSection()->getLabel();
            }
        }

        $newUserDTO->areSuccessUnlockedVisible = $user->getAreSuccessUnlockedVisible();

        $successDTOs = [];
        $userSuccessCollection = $this->em->getRepository(Success::class)->findBy(['user' => $user]);

        foreach ($userSuccessCollection as $success)
        {
            $successDTO = $this->successDTOAssembler->getFromSuccess($success);
            $successDTOs[] = $successDTO;
        }
        $newUserDTO->successDTOs = $successDTOs;

        $newUserDTO->areActivityParticipationVisible = $user->getAreActivityParticipationVisible();
        $newUserDTO->isPersonalProfileVisible = $user->getIsPersonalProfileVisible();

        $picturesDTOs = [];
        $profilePictures = $user->getPictures();
        foreach ($profilePictures as $picture)
        {
            $pictureDTO = $this->pictureDTOAssembler->getFromPicture($picture);
            $picturesDTOs[] = $pictureDTO;
        }
        $newUserDTO->pictureDTOs = $picturesDTOs;

        $newUserDTO->canGoAway = $user->getCanGoAway();
        $newUserDTO->activityCostLimit = $user->getActivityCostLimit();

        $preferredPartnerDTOs = [];
        $preferredPartners = $user->getPreferredPartners();
        foreach ($preferredPartners as $partner)
        {
            $preferredPartnerDTO = $this->preferredPartnerDTOAssembler->getFromUser($partner);
            $preferredPartnerDTOs[] = $preferredPartnerDTO;
        }
        $newUserDTO->preferredPartnerDTOs = $preferredPartnerDTOs;

        $disponibilityPatterns = [];
        $disponibilityPatternsValuesArray = $user->getDisponibilityPatterns();
        $disponibilityPatternTokenArray = $user::getDisponibilityPatternTokenArray();
        foreach($disponibilityPatternsValuesArray as $disponibilityPatternValue)
        {
            $disponibilityPatternToken =  array_search ($disponibilityPatternValue, $disponibilityPatternTokenArray);
            $disponibilityPatternTokenTranslated = $this->translator->trans($disponibilityPatternToken, [], 'messages');
            $disponibilityPattern = ['value'=> $disponibilityPatternValue, 'label' => $disponibilityPatternTokenTranslated];
            $disponibilityPatterns[] = $disponibilityPattern;
        }
        $newUserDTO->disponibilityPatterns = $disponibilityPatterns;

        // label count array creation
        $addressedUserRelatedFeedbackLabelsCumuled = [];
        $distinctUserRelatedFeedbackLabelArray = UserRelatedFeedback::getLabelValueTokenArray();
        foreach($distinctUserRelatedFeedbackLabelArray as $token => $value)
        {
            $addressedUserRelatedFeedbackLabelsCumuled[$value] = [
                'label' => $this->translator->trans($token, [], 'messages'),
                'value' => $value,
                'count' => 0,
                'percent' => 0,
            ];
        }

        $addressedUserRelatedFeedbackDTOs = [];
        $addressedUserRelatedFeedbackArray = $this->em->getRepository(UserRelatedFeedback::class)->findBy(['user' => $user]);
        $totalUserRelatedFeedback = count($addressedUserRelatedFeedbackArray);
        foreach ($addressedUserRelatedFeedbackArray as $addressedUserRelatedFeedback)
        {
            /** @var UserRelatedFeedback $addressedUserRelatedFeedback */
            // DTOs
            $addressedUserRelatedFeedbackDTO = $this->userRelatedFeedbackDTOAssembler->getFromUserRelatedFeedback($addressedUserRelatedFeedback);
            $addressedUserRelatedFeedbackDTOs[] = $addressedUserRelatedFeedbackDTO;

            // label count
            $addressedUserRelatedFeedbackLabelsCumuled[$addressedUserRelatedFeedback->getLabel()]['count'] += 1;

            // label percent
            $labelPercent = ($addressedUserRelatedFeedbackLabelsCumuled[$addressedUserRelatedFeedback->getLabel()]['count'] / $totalUserRelatedFeedback) * 100;
            $addressedUserRelatedFeedbackLabelsCumuled[$addressedUserRelatedFeedback->getLabel()]['percent'] = $labelPercent;
        }
        $newUserDTO->addressedUserRelatedFeedbackDTOs = $addressedUserRelatedFeedbackDTOs;

        // aggregated UserRelatedFeedback
        $newUserDTO->addressedUserRelatedFeedbackLabelsCumuled = array_values($addressedUserRelatedFeedbackLabelsCumuled);

        // next activityParticipation
        $nextActivityParticipationQueryResult = $this->em->getRepository(ActivityParticipation::class)->getNextsForUser($user);
        $nextActivityParticipation = null;
        foreach ($nextActivityParticipationQueryResult as $activityParticipation)
        {
            if (is_null($nextActivityParticipation)) {
                /**@var ActivityParticipation $activityParticipation */
                $relatedActivity = $activityParticipation->getActivity();
                $relatedActivityCancellation = $this->em->getRepository(ActivityCancellation::class)->findOneBy([
                    'cancellingUser' => $user,
                    'activity' => $relatedActivity
                ]);
                if (is_null($relatedActivityCancellation)) {
                    $nextActivityParticipation = $activityParticipation;
                }
            }

        }
        if(!is_null($nextActivityParticipation))
        {
            $nextActivityParticipationDTO = $this->activityParticipationDTOAssembler->getFromActivityParticipationForAppCommon($nextActivityParticipation);
            $newUserDTO->nextActivityParticipationDTO = $nextActivityParticipationDTO;
        }

        // next crucial Meeting
        $nextCrucialMeetingQueryResult = $this->em->getRepository(CrucialMeeting::Class)->getNext();
        if(!is_null($nextCrucialMeetingQueryResult) && ( 0 < count($nextCrucialMeetingQueryResult)))
        {
            $nextCrucialMeeting = $nextCrucialMeetingQueryResult[0];
            $nextCrucialMeetingDTO = $this->crucialMeetingDTOAssembler->getFromCrucialMeetingForAppCommon($nextCrucialMeeting);
            $newUserDTO->nextCrucialMeetingDTO = $nextCrucialMeetingDTO;
        }

        // sport profiles
        $sportProfileDTOs = [];
        $sportProfilesQueryResult = $this->em->getRepository(SportProfile::class)->findBy(['user' => $user]);
        if(!is_null($sportProfilesQueryResult) && (0 < count($sportProfilesQueryResult)))
        {
            foreach ($sportProfilesQueryResult as $sportProfile)
            {
                $sportProfileDTOs[] = $this->sportProfileDTOAssembler->getFromSportProfileForAppCommon($sportProfile);
            }
        }
        $newUserDTO->sportProfileDTOs = $sportProfileDTOs;

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