<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 7/04/19
 * Time: 10:21
 */

namespace App\EventListener\Profile;


use App\Entity\Activity\ActivityParticipation;
use App\Entity\Activity\UserRelatedFeedback;
use App\Entity\Profile\Success;
use App\Repository\Activity\UserRelatedFeedbackRepository;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManagerInterface;

class SuccessListener
{

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // Only Triggers on UserFeedback or ActivityParticipation persistence
        if ( (!$entity instanceof UserRelatedFeedback) && (!$entity instanceof ActivityParticipation) ) {
            return;
        }

        $em = $args->getObjectManager();
        
        if ($entity instanceof UserRelatedFeedback)
        {
            $concernedUser = $entity->getUser();

            //
            //
            // 10 Friendly feedback Success
            //
            //
            //Compter le nombre d esuccès existants pour cet utilisateur
            $userFeedbacksFriendly = $em->getRepository(UserRelatedFeedback::class)->findBy([
                'user' => $concernedUser->getId(),
                'label' => UserRelatedFeedback::USER_RELATED_FEEDBACK_LABEL_VALUE_FRIENDLY
            ]);
            if (10 === count($userFeedbacksFriendly))
            {
                // vérifier qu'il n'existe pas déja un succès pour cet user
                $alreadyExisting10FriendlyFeedbackSuccess = $em->getRepository(Success::class)->findOneBy([
                    'user' => $concernedUser->getId(),
                    'label' => Success::SUCCESS_LABEL_VALUE_TEN_TIMES_FRIENDLY
                ]);
                if (is_null($alreadyExisting10FriendlyFeedbackSuccess))
                {
                    // créer nouveau succès 10 friendly
                    $newSucces = new Success();
                    $newSucces->setUser($concernedUser);
                    $newSucces->setLabel(Success::SUCCESS_LABEL_VALUE_TEN_TIMES_FRIENDLY);
                    $em->persist($newSucces);
                    $em->flush();
                }
            }



            //
            //
            //  10 MVP feedback Success
            //
            //
            //Compter le nombre de succès existants pour cet utilisateur
            $userFeedbacksFriendly = $em->getRepository(UserRelatedFeedback::class)->findBy([
                'user' => $concernedUser->getId(),
                'label' => UserRelatedFeedback::USER_RELATED_FEEDBACK_LABEL_VALUE_MVP
            ]);
            if (10 === count($userFeedbacksFriendly))
            {
                // vérifier qu'il n'existe pas déja un succès pour cet user
                $alreadyExisting10MVPFeedbackSuccess = $em->getRepository(Success::class)->findOneBy([
                    'user' => $concernedUser->getId(),
                    'label' => Success::SUCCESS_LABEL_VALUE_TEN_TIMES_MVP
                ]);
                if (is_null($alreadyExisting10MVPFeedbackSuccess))
                {
                    // créer nouveau succès 10 MVP
                    $newSucces = new Success();
                    $newSucces->setUser($concernedUser);
                    $newSucces->setLabel(Success::SUCCESS_LABEL_VALUE_TEN_TIMES_MVP);
                    $em->persist($newSucces);
                    $em->flush();
                }
            }

            //
            //
            //  10 Fairplay feedback Success
            //
            //
            //Compter le nombre d esuccès existants pour cet utilisateur
            $userFeedbacksFriendly = $em->getRepository(UserRelatedFeedback::class)->findBy([
                'user' => $concernedUser->getId(),
                'label' => UserRelatedFeedback::USER_RELATED_FEEDBACK_LABEL_VALUE_FAIRPLAY
            ]);
            if (10 === count($userFeedbacksFriendly))
            {
                // vérifier qu'il n'existe pas déja un succès pour cet user
                $alreadyExisting10FairplayFeedbackSuccess = $em->getRepository(Success::class)->findOneBy([
                    'user' => $concernedUser->getId(),
                    'label' => Success::SUCCESS_LABEL_VALUE_TEN_TIMES_FAIR_PLAY
                ]);
                if (is_null($alreadyExisting10FairplayFeedbackSuccess))
                {
                    // créer nouveau succès 10 Fairplay
                    $newSucces = new Success();
                    $newSucces->setUser($concernedUser);
                    $newSucces->setLabel(Success::SUCCESS_LABEL_VALUE_TEN_TIMES_FAIR_PLAY);
                    $em->persist($newSucces);
                    $em->flush();
                }
            }

        }

        if ($entity instanceof ActivityParticipation)
        {
            $concernedUser = $entity->getUser();
            //
            //
            //  10 Participations à une activité
            //
            //
            //Compter le nombre d esuccès existants pour cet utilisateur
            $userActivityParticipation = $em->getRepository(ActivityParticipation::class)->findBy([
                'user' => $concernedUser->getId(),
                'isConfirmed' => TRUE
            ]);
            if (10 === count($userActivityParticipation))
            {
                // vérifier qu'il n'existe pas déja un succès pour cet user
                $alreadyExisting10ActivityParticipationSuccess = $em->getRepository(Success::class)->findOneBy([
                    'user' => $concernedUser->getId(),
                    'label' => Success::SUCCESS_LABEL_VALUE_TEN_ACTIVITY_PARTICIPATION
                ]);
                if (is_null($alreadyExisting10ActivityParticipationSuccess))
                {
                    // créer nouveau succès 10 Fairplay
                    $newSucces = new Success();
                    $newSucces->setUser($concernedUser);
                    $newSucces->setLabel(Success::SUCCESS_LABEL_VALUE_TEN_ACTIVITY_PARTICIPATION);
                    $em->persist($newSucces);
                    $em->flush();
                }
            }
        }

//
//
//        $entityManager = $args->getObjectManager();
//        // ... do something with the Product
    }

}