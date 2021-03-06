<?php
/**
 * Created by PhpStorm.
 * User: jpire
 * Date: 17/05/19
 * Time: 12:02
 */

namespace App\Managers\Promotion;


use ApiPlatform\Core\Exception\ItemNotFoundException;
use App\Entity\Promotion\Achievement;
use App\Entity\Promotion\CrucialMeeting;
use App\Entity\Promotion\EmeritusSportMan;
use App\Entity\Promotion\OfficialTeam;
use App\Entity\Promotion\ShoutOut;
use App\Entity\User\User;
use App\Exception\InvalidArgumentException;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class PromotionManager
{

    private $em;
    private $security;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->em = $entityManager;
    }

    public function getNextCrucialMeetings()
    {
        $meetingsQueryResult = $this->em->getRepository(CrucialMeeting::class)->getNexts();
        return $meetingsQueryResult;

    }

    public function getOfficialTeams()
    {

        $teams = $this->em->getRepository(OfficialTeam::class)->findAll();

        return $teams;

    }

    public function getOfficialTeam($id)
    {
        $team = $this->em->getRepository(OfficialTeam::class)->find($id);
        if (is_null($team)) {
            return null;
        }
        return $team;

    }

    /**
     * @param ShoutOut $shoutout
     * @return ShoutOut
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function persistShoutOut(ShoutOut $shoutout)
    {
        //
        // Restricting access
        if (is_null($this->security->getToken())|| is_null($this->security->getToken()->getUser()||$this->security->getToken()->getUser()->getId()))
        {
            throw new AccessDeniedException('Restricted area');
        }
        /** @var User $connectedUser */
        $connectedUser = $this->security->getToken()->getUser();

        $now = new DateTime();

        $shoutout->setCreatedBy($connectedUser);
        $shoutout->setAuthor($connectedUser);
        $shoutout->setCreatedAt($now);

        if(is_null($shoutout->getOfficialTeamTarget()) &&  is_null($shoutout->getEmeritusSportManTarget()))
        {
            throw new InvalidArgumentException('Please specify a target for the shout out');
        }

        $this->em->persist($shoutout);
        $this->em->flush();

        return $shoutout;
    }

    public function getShoutOutsForAnOfficialTeam($id)
    {
        //
        // Restricting access
        if (is_null($this->security->getToken())|| is_null($this->security->getToken()->getUser()||$this->security->getToken()->getUser()->getId()))
        {
            throw new AccessDeniedException('Restricted area');
        }
        /** @var User $connectedUser */
        $connectedUser = $this->security->getToken()->getUser();

        $officialTeamTarget = $this->em->getRepository(OfficialTeam::class)->find($id);
        if(is_null($officialTeamTarget))
        {
            throw new ItemNotFoundException('Official team not found');
        }

        $shoutOuts = $this->em->getRepository(ShoutOut::class)->findBy([
            'author' => $connectedUser,
            'officialTeamTarget' => $officialTeamTarget
        ],[
            'createdAt'=>'DESC'
        ]);

        return $shoutOuts;

    }

    public function getShoutOutsForAnEmeritusSportMan($id)
    {
        //
        // Restricting access
        if (is_null($this->security->getToken())|| is_null($this->security->getToken()->getUser()||$this->security->getToken()->getUser()->getId()))
        {
            throw new AccessDeniedException('Restricted area');
        }
        /** @var User $connectedUser */
        $connectedUser = $this->security->getToken()->getUser();

        $emeritusSportManTarget = $this->em->getRepository(EmeritusSportMan::class)->find($id);
        if(is_null($emeritusSportManTarget))
        {
            throw new ItemNotFoundException('Emeritus sport man not found');
        }

        $shoutOuts = $this->em->getRepository(ShoutOut::class)->findBy([
            'author' => $connectedUser,
            'emeritusSportManTarget' => $emeritusSportManTarget
        ]);

        return $shoutOuts;
    }


}