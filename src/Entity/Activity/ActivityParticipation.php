<?php

namespace App\Entity\Activity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Activity\UserRelatedFeedback;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\Actions\Activity\GetActivityParticipationsForAnActivity;


/**
 * @ApiResource(
 *     itemOperations={
 *          "getParticipation" = {
 *              "method"="GET",
 *              "path"= "/activities/participations/{id}",
 *              "denormalization_context"={"groups"={"get-participation"} },
 *              "normalization_context"={"groups"={"get-participation"} }
 *           },
 *          "putParticipation" = {
 *              "method"="PUT",
 *              "path"="/activities/participations/{id}",
 *              "denormalization_context"={"groups"={"get-participation"} },
 *              "normalization_context"={"groups"={"get-participation"} },
 *              "validation_groups"={"putParticipationValidation, Default"}
 *          }
 *     },
 *     collectionOperations={
 *          "getParticipationsForAUser" = {
 *              "method"="GET",
 *              "path"="/activities/participations/",
 *              "denormalization_context"={"groups"={"get-participations"} },
 *              "normalization_context"={"groups"={"get-participations"} },
 *          },
 *          "getParticipationsForAnActivity" = {
 *              "method"="GET",
 *              "path"="/activities/{id}/participations/",
 *              "denormalization_context"={"groups"={"get-participations-for-an-activity"} },
 *              "normalization_context"={"groups"={"get-participations-for-an-activity"} },
 *              "controller"=GetActivityParticipationsForAnActivity::class,
 *              "requirements"={"id"="\d+"}
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\Activity\ActivityParticipationRepository")
 * @UniqueEntity(
 *     fields={"activity", "user"},
 *     errorPath="user",
 *     message="ACTIVITY_PARTICIPATION_ALREADY_MADE_TOKEN"
 * )
 */
class ActivityParticipation
{
    /**
     * @Groups({"get-participation","get-participations", "get-participations-for-an-activity"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"get-participation","get-participations", "get-participations-for-an-activity"})
     * @Assert\NotNull(groups={"putParticipationValidation"})
     * @Assert\Type(type="bool")
     * @ORM\Column(type="boolean")
     */
    private $isConfirmed;

    /**
     * @Groups({"get-participation","get-participations", "get-participations-for-an-activity"})
     * @Assert\NotNull
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity\Activity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;

    /**
     * @Groups({"get-participations-for-an-activity"})
     * @Assert\NotNull
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @Groups({"get-participation","get-participations", "get-participations-for-an-activity"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $answeredAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsConfirmed(): ?bool
    {
        return $this->isConfirmed;
    }

    public function setIsConfirmed(bool $isConfirmed): self
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }

    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(?Activity $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAnsweredAt(): ?\DateTimeInterface
    {
        return $this->answeredAt;
    }

    public function setAnsweredAt(?\DateTimeInterface $answeredAt): self
    {
        $this->answeredAt = $answeredAt;

        return $this;
    }

}
