<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 1/05/19
 * Time: 8:29
 */

namespace App\Assemblers\Profile\DTO;


use App\Entity\Profile\DTO\ProfileDTO;
use App\Entity\User\User;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProfileDTOAssembler
{

    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;

    }

    public function getFromUser(User $user, User $callingUser)
    {

        $profileDTO = new ProfileDTO();

        $profileDTO->id = $user->getId();
        $profileDTO->username = $user->getUsername();
        $profileDTO->picture = $user->getProfilePicture();

        $schoolClass = $user->getSchoolClass();
        $profileDTO->schoolClass = is_null($schoolClass) ? $schoolClass : $schoolClass->getLabel();

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
        $profileDTO->disponibilityPatterns = $disponibilityPatterns;

        if( ($callingUser->getId()) != ($user->getId()) )
        {
            $callingUserPreferredPartners = $callingUser->getPreferredPartners();
            if ($callingUserPreferredPartners->contains($user))
            {
                $profileDTO->isMyPartner = true;
            }
            else
            {
                $profileDTO->isMyPartner = false;
            }

        }


//    public $newPassword;
//    public $areSuccessUnlockedVisible;
//    public $areActivityParticipationVisible;
//    public $isPersonalProfileVisible;
//    public $picture;
//    public $pictureFile;
//    public $pictureName;
//
//
//    public $description;
//    public $email;
//    public $phoneNumber;
//
//    public $gender;
//    public $birthDate;
//    public $pictures;
//    public $schoolClass;
//
//    public $canGoAway;
//    public $activityCostLimit;
//    public $disponibilityPatterns;
//    public $preferredPartnerIds;



        return $profileDTO;

    }

}