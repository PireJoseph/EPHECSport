<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 8/05/19
 * Time: 18:25
 */

namespace App\Managers\Activity;


use App\Entity\Activity\Activity;
use App\Entity\Activity\ActivityRelatedFeedback;
use App\Entity\Activity\Sport;
use App\Entity\User\User;
use App\Form\Activity\ActivityRelatedFeedbackLabelType;
use Doctrine\ORM\EntityManagerInterface;
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


}