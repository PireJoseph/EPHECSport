<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 7/04/19
 * Time: 15:26
 */

namespace App\EventListener\Activity;


use App\Entity\Activity\ActivityInvitation;
use App\Entity\Activity\ActivityJoiningRequest;
use App\Entity\Activity\ActivityParticipation;
use App\Entity\Activity\UserRelatedFeedback;
use Doctrine\ORM\Event\LifecycleEventArgs;

class ActivityParticipationListener
{

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // Only Triggers on UserFeedback or ActivityParticipation persistence
        if ( (!$entity instanceof ActivityInvitation) && (!$entity instanceof ActivityJoiningRequest) && (!$entity instanceof UserRelatedFeedback)) {
            return;
        }

        $em = $args->getObjectManager();

        if ($entity instanceof ActivityInvitation)
        {
            $concernedUser = $entity->getRecipitent();
            $concernedActivity = $entity->getActivity();

            $invitationAccepted = $entity->getIsAccepted();
            if(TRUE === $invitationAccepted)
            {
                // vérifier s'il existe déja une participation pour cette activité
                $alreadyExistingActivityParticipation = $em->getRepository(ActivityParticipation::class)->findOneBy([
                    'user' => $concernedUser,
                    'activity' => $concernedActivity
                ]);
                // s'il n'existe pas de participation, en créer une
                if (is_null($alreadyExistingActivityParticipation))
                {
                    $newActivityParticipation = new ActivityParticipation();
                    $newActivityParticipation->setUser($concernedUser);
                    $newActivityParticipation->setActivity($concernedActivity);
                    $newActivityParticipation->setIsConfirmed(FALSE);
                    $em->persist($newActivityParticipation);
                    $em->flush();
                }
            }
        }

        if ($entity instanceof ActivityJoiningRequest)
        {
            $concernedUser = $entity->getRecipitent();
            $concernedActivity = $entity->getActivity();
            $activityJoinableByAnyone = $concernedActivity->getIsJoinableByAnyone();
            $joiningRequestAccepted = $entity->getIsAccepted();
            if( (TRUE === $activityJoinableByAnyone) || (TRUE === $joiningRequestAccepted) )
            {
                // vérifier s'il existe déja une participation pour cette activité
                $alreadyExistingActivityParticipation = $em->getRepository(ActivityParticipation::class)->findOneBy([
                    'user' => $concernedUser,
                    'activity' => $concernedActivity
                ]);
                // s'il n'existe pas de participation, en créer une
                if (is_null($alreadyExistingActivityParticipation))
                {
                    $newActivityParticipation = new ActivityParticipation();
                    $newActivityParticipation->setUser($concernedUser);
                    $newActivityParticipation->setActivity($concernedActivity);
                    $newActivityParticipation->setIsConfirmed(FALSE);
                    $em->persist($newActivityParticipation);
                    $em->flush();
                }
            }

        }

        if ($entity instanceof UserRelatedFeedback)
        {
            $concernedUser = $entity->getUser();
            $concernedActivity = $entity->getActivity();

            // vérifier s'il existe déja une participation pour cette activité
            $alreadyExistingActivityParticipation = $em->getRepository(ActivityParticipation::class)->findOneBy([
                'user' => $concernedUser,
                'activity' => $concernedActivity
            ]);
            // s'il n'existe pas de participation, en créer une
            if (is_null($alreadyExistingActivityParticipation))
            {
                $newActivityParticipation = new ActivityParticipation();
                $newActivityParticipation->setUser($concernedUser);
                $newActivityParticipation->setActivity($concernedActivity);
                $newActivityParticipation->setIsConfirmed(FALSE);
                $em->persist($newActivityParticipation);
                $em->flush();
            }

        }

    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // Only Triggers on UserFeedback or ActivityParticipation persistence
        if ( (!$entity instanceof ActivityInvitation) && (!$entity instanceof ActivityJoiningRequest) ) {
            return;
        }

        $em = $args->getObjectManager();

        if ($entity instanceof ActivityInvitation)
        {
            $concernedUser = $entity->getRecipitent();
            $concernedActivity = $entity->getActivity();

            $invitationAccepted = $entity->getIsAccepted();
            if(TRUE === $invitationAccepted)
            {
                // vérifier s'il existe déja une participation pour cette activité
                $alreadyExistingActivityParticipation = $em->getRepository(ActivityParticipation::class)->findOneBy([
                    'user' => $concernedUser,
                    'activity' => $concernedActivity
                ]);
                // s'il n'existe pas de participation, en créer une
                if (is_null($alreadyExistingActivityParticipation))
                {
                    $newActivityParticipation = new ActivityParticipation();
                    $newActivityParticipation->setUser($concernedUser);
                    $newActivityParticipation->setActivity($concernedActivity);
                    $newActivityParticipation->setIsConfirmed(FALSE);
                    $em->persist($newActivityParticipation);
                    $em->flush();
                }
            }
        }


        if ($entity instanceof ActivityJoiningRequest)
        {
            $concernedUser = $entity->getRecipitent();
            $concernedActivity = $entity->getActivity();
            $joiningRequestAccepted = $entity->getIsAccepted();
            if(TRUE === $joiningRequestAccepted)
            {
                // vérifier s'il existe déja une participation pour cette activité
                $alreadyExistingActivityParticipation = $em->getRepository(ActivityParticipation::class)->findOneBy([
                    'user' => $concernedUser,
                    'activity' => $concernedActivity
                ]);
                // s'il n'existe pas de participation, en créer une
                if (is_null($alreadyExistingActivityParticipation))
                {
                    $newActivityParticipation = new ActivityParticipation();
                    $newActivityParticipation->setUser($concernedUser);
                    $newActivityParticipation->setActivity($concernedActivity);
                    $newActivityParticipation->setIsConfirmed(FALSE);
                    $em->persist($newActivityParticipation);
                    $em->flush();
                }
            }

        }

        if ($entity instanceof UserRelatedFeedback)
        {
            $concernedUser = $entity->getUser();
            $concernedActivity = $entity->getActivity();

            // vérifier s'il existe déja une participation pour cette activité
            $alreadyExistingActivityParticipation = $em->getRepository(ActivityParticipation::class)->findOneBy([
                'user' => $concernedUser,
                'activity' => $concernedActivity
            ]);
            // s'il n'existe pas de participation, en créer une
            if (is_null($alreadyExistingActivityParticipation))
            {
                $newActivityParticipation = new ActivityParticipation();
                $newActivityParticipation->setUser($concernedUser);
                $newActivityParticipation->setActivity($concernedActivity);
                $newActivityParticipation->setIsConfirmed(FALSE);
                $em->persist($newActivityParticipation);
                $em->flush();
            }

        }


    }
}