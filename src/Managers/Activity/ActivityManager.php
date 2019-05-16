<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 8/05/19
 * Time: 18:25
 */

namespace App\Managers\Activity;


use App\Entity\Activity\Activity;
use App\Entity\Activity\ActivityCancellation;
use App\Entity\Activity\ActivityInvitation;
use App\Entity\Activity\ActivityJoiningRequest;
use App\Entity\Activity\ActivityParticipation;
use App\Entity\Activity\ActivityRelatedFeedback;
use App\Entity\Activity\Sport;
use App\Entity\User\User;
use App\Form\Activity\ActivityRelatedFeedbackLabelType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class ActivityManager
{

    private $em;
    private $security;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->em = $entityManager;
    }

    public function getSports()
    {
       return  $this->em->getRepository(Sport::class)->findAll();
    }



    public function getActivityHistory()
    {
        //
        // Restricting access
        if (is_null($this->security->getToken())|| is_null($this->security->getToken()->getUser()||$this->security->getToken()->getUser()->getId()))
        {
            throw new AccessDeniedException('Restricted area');
        }
        $connectedUser = $this->security->getToken()->getUser();

        $activityHistoryForTheUser = $this->em->getRepository(Activity::class)->getHistoryForUser($connectedUser);

        return $activityHistoryForTheUser;

    }

    public function getActivityFeedback($id)
    {
        //
        // Restricting access
        if (is_null($this->security->getToken())|| is_null($this->security->getToken()->getUser()||$this->security->getToken()->getUser()->getId()))
        {
            throw new AccessDeniedException('Restricted area');
        }
        /** @var User $connectedUser */
        $connectedUser = $this->security->getToken()->getUser();

        $activityRelatedFeedback = $this->em->getRepository(ActivityRelatedFeedback::class)->findOneBy([
            'author' => $connectedUser->getId(),
            'activity' => $id
        ]);

        return $activityRelatedFeedback;
    }

    /**
     * @param ActivityRelatedFeedback $activityRelatedFeedback
     * @return ActivityRelatedFeedback
     */
    public function persistActivityRelatedFeedback(ActivityRelatedFeedback $activityRelatedFeedback)
    {
        //
        // Restricting access
        if (is_null($this->security->getToken())|| is_null($this->security->getToken()->getUser()||$this->security->getToken()->getUser()->getId()))
        {
            throw new AccessDeniedException('Restricted area');
        }
        $activityRelatedFeedback->setAuthor($this->security->getToken()->getUser());
        $activityRelatedFeedback->setCreatedBy($this->security->getToken()->getUser());

        $this->em->persist($activityRelatedFeedback);
        $this->em->flush();

        return $activityRelatedFeedback;
    }

    public function getAvailableActivities()
    {
        //
        // Restricting access
        if (is_null($this->security->getToken())|| is_null($this->security->getToken()->getUser()||$this->security->getToken()->getUser()->getId()))
        {
            throw new AccessDeniedException('Restricted area');
        }
        $connectedUser = $this->security->getToken()->getUser();

        $availableActivitiesArray = [];

        $activityParticipationQueryResult = $this->em->getRepository(ActivityParticipation::class)->findBy(['user' => $connectedUser]);
        $activityIdsArray = [];
        foreach($activityParticipationQueryResult as $activityParticipation)
        {
            /** @var ActivityParticipation $acitivityParticipation */
            $activityIdsArray[] = $activityParticipation->getActivity()->getId();
        }


        $availableActivitiesQueryResult = $this->em->getRepository(Activity::Class)->getAvailable($activityIdsArray);

        foreach($availableActivitiesQueryResult as $availableActivity)
        {
            $item = [];
            $item['activity'] = $availableActivity;
            /** @var Activity $availableActivity */
            $activityJoiningRequest = $this->em->getRepository(ActivityJoiningRequest::class)->findOneBy(['activity' => $availableActivity->getId()]);
            $item['relatedRequest'] = $activityJoiningRequest;
            $availableActivitiesArray[] = $item;
        }


        return $availableActivitiesArray;

    }

    /**
     * @param ActivityJoiningRequest $activityJoiningRequest
     * @return ActivityJoiningRequest
     * @throws Exception
     */
    public function makeActivityJoiningRequest(ActivityJoiningRequest $activityJoiningRequest)
    {
        //
        // Restricting access
        if (is_null($this->security->getToken()) || is_null($this->security->getToken()->getUser() || $this->security->getToken()->getUser()->getId())) {
            throw new AccessDeniedException('Restricted area');
        }
        $connectedUser = $this->security->getToken()->getUser();


        // create the request
        $activityJoiningRequest->setCreatedBy($connectedUser);

        $now = new DateTime();
        $activityJoiningRequest->setCreatedAt($now);
        $activityJoiningRequest->setIsAccepted(false);
        $activityJoiningRequest->setRecipitent($connectedUser);

        // persist the request -> event listener will persist a participation if activity is joinable by anyone
        $this->em->persist($activityJoiningRequest);
        $this->em->flush();

        return $activityJoiningRequest;

    }

    public function getActivityInvitations()
    {
        //
        // Restricting access
        if (is_null($this->security->getToken()) || is_null($this->security->getToken()->getUser() || $this->security->getToken()->getUser()->getId())) {
            throw new AccessDeniedException('Restricted area');
        }
        $connectedUser = $this->security->getToken()->getUser();

        $activityInvitations = $this->em->getRepository(ActivityInvitation::class)->getNonAnsweredForThisUser($connectedUser);

        return $activityInvitations;

    }

    /**
     * @param ActivityInvitation $activityInvitation
     * @return ActivityInvitation
     * @throws Exception
     */
    public function answerActivityInvitation(ActivityInvitation $activityInvitation)
    {
        //
        // Restricting access
        if (is_null($this->security->getToken()) || is_null($this->security->getToken()->getUser() || $this->security->getToken()->getUser()->getId())) {
            throw new AccessDeniedException('Restricted area');
        }

        $now = new DateTime();

        $activityInvitation->setAnsweredAt($now);
        $this->em->persist($activityInvitation);
        $this->em->flush();

        return $activityInvitation;

    }

    public function getActivityParticipations()
    {

        //
        // Restricting access
        if (is_null($this->security->getToken())|| is_null($this->security->getToken()->getUser()||$this->security->getToken()->getUser()->getId()))
        {
            throw new AccessDeniedException('Restricted area');
        }
        $connectedUser = $this->security->getToken()->getUser();

        $activityParticipationArray = [];
        $itemArray = [];
        $activityParticipationQueryResult = $this->em->getRepository(ActivityParticipation::class)->getNextsForUserWithRelatedCancellation($connectedUser);
        foreach ($activityParticipationQueryResult as $entity) {
            if ($entity instanceof ActivityParticipation) {
                $itemArray['participation'] = $entity;
            }
            else {
                $itemArray['cancellation'] = $entity;
                $activityParticipationArray[] = $itemArray;
                $itemArray = [];
            }
        }



        return $activityParticipationArray;


    }

    public function persistActivityParticipation(ActivityParticipation $activityParticipation)
    {
        //
        // Restricting access
        if (is_null($this->security->getToken())|| is_null($this->security->getToken()->getUser()||$this->security->getToken()->getUser()->getId()))
        {
            throw new AccessDeniedException('Restricted area');
        }
        $connectedUser = $this->security->getToken()->getUser();

        $this->em->persist($activityParticipation);
        $this->em->flush();

        return $activityParticipation;
    }

    public function persistActivityCancellation(ActivityCancellation $activityCancellation)
    {
        //
        // Restricting access
        if (is_null($this->security->getToken())|| is_null($this->security->getToken()->getUser()||$this->security->getToken()->getUser()->getId()))
        {
            throw new AccessDeniedException('Restricted area');
        }
        $connectedUser = $this->security->getToken()->getUser();

        $activityCancellation->setCreatedBy($connectedUser);
        $activityCancellation->setCancellingUser($connectedUser);

        $this->em->persist($activityCancellation);
        $this->em->flush();

        return $activityCancellation;
    }


}