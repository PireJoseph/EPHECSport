<?php

namespace App\Entity\Activity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     itemOperations={
 *          "getInvitation" = {
 *              "method"="GET",
 *              "path"= "/activities/invitations/{id}",
 *              "denormalization_context"={"groups"={"get-invitation"} },
 *              "normalization_context"={"groups"={"get-invitation"} }
 *           },
 *          "putInvitation" = {
 *              "method"="PUT",
 *              "path"="/activities/invitations/{id}",
 *              "denormalization_context"={"groups"={"put-invitation"} },
 *              "normalization_context"={"groups"={"put-invitation"} },
 *              "validation_groups"={"putInvitationValidation"}
 *          }
 *     },
 *     collectionOperations={
 *          "getInvitations" = {
 *              "method"="GET",
 *              "path"="/activities/invitations/",
 *              "denormalization_context"={"groups"={"get-invitations"} },
 *              "normalization_context"={"groups"={"get-invitations"} },
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\Activity\ActivityInvitationRepository")
 * @UniqueEntity(
 *     fields={"activity", "recipitent"},
 *     errorPath="recipitent",
 *     message="ACTIVITY_INVITATION_ALREADY_MADE_TOKEN"
 * )
 */
class ActivityInvitation
{
    /**
     * @Groups({"get-invitation","get-invitations", "put-invitation"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"get-invitation","get-invitations"})
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Groups({"get-invitation","get-invitations", "put-invitation"})
     * @Assert\Type(type="bool",groups={"Default, putInvitationValidation"})
     * @ORM\Column(type="boolean")
     */
    private $isAccepted;

    /**
     * @Groups({"get-invitation","get-invitations"})
     * @Assert\NotNull(groups={"Default, putInvitationValidation"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity\Activity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;

    /**
     * @Groups({"get-invitation","get-invitations"})
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @Assert\NotNull
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipitent;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $answeredAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getIsAccepted(): ?bool
    {
        return $this->isAccepted;
    }

    public function setIsAccepted(bool $isAccepted): self
    {
        $this->isAccepted = $isAccepted;

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

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getRecipitent(): ?User
    {
        return $this->recipitent;
    }

    public function setRecipitent(?User $recipitent): self
    {
        $this->recipitent = $recipitent;

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
