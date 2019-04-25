<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 25/04/19
 * Time: 3:58
 */

namespace App\Assemblers\Activity\DTO;


use App\Entity\Activity\DTO\UserRelatedFeedBackDTO;
use App\Entity\Activity\UserRelatedFeedback;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserRelatedFeedbackDTOAssembler
{

    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getFromUserRelatedFeedback(UserRelatedFeedback $userRelatedFeedback)
    {
        $userRelatedFeedbackDTO = new UserRelatedFeedBackDTO();
        $userRelatedFeedbackDTO->id = $userRelatedFeedback->getId();
        $label = $userRelatedFeedback->getLabel();
        $userRelatedFeedbackDTO->labelValue = $label;
        $userRelatedFeedbackLabelToken = UserRelatedFeedback::getLabelToken($label);
        if(!is_null($userRelatedFeedbackLabelToken))
        {
            $translatedLabel = $this->translator->trans($userRelatedFeedbackLabelToken, [], 'messages');
            $userRelatedFeedbackDTO->label = $translatedLabel;
        }
        $userRelatedFeedbackDTO->isReallyPresent = $userRelatedFeedback->getIsReallyPresent();
        $activity = $userRelatedFeedback->getActivity();
        $userRelatedFeedbackDTO->activityId = $activity->getId();
        $userRelatedFeedbackDTO->activityLabel = $activity->getLabel();
        $user = $userRelatedFeedback->getUser();
        $userRelatedFeedbackDTO->userId = $user->getId();
        $userRelatedFeedbackDTO->userUsername = $user->getUsername();
        $createdBy = $userRelatedFeedback->getCreatedBy();
        if(!is_null($createdBy))
        {
            $userRelatedFeedbackDTO->createdById = $createdBy->getId();
            $userRelatedFeedbackDTO->createdByUsername = $createdBy->getUsername();
        }
        return $userRelatedFeedbackDTO;
    }

}