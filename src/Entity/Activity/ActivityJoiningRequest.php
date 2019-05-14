<?php

namespace App\Entity\Activity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\Actions\Activity\MakeActivityJoiningRequest;

/**
 * @ApiResource(
 *     itemOperations={
 *          "get" = {
 *              "method"="GET",
 *              "path"= "/activities/requests/{id}",
 *              "denormalization_context"={"groups"={"get-request"} },
 *              "normalization_context"={"groups"={"get-request"} }
 *           }
 *     },
 *     collectionOperations={
 *          "makeRequest" = {
 *              "method"="POST",
 *              "path"="/activities/requests/",
 *              "denormalization_context"={"groups"={"make-request"} },
 *              "normalization_context"={"groups"={"make-request"} },
 *              "validation_groups"={"makeRequestValidation"}
 *          }
 *     },
 * )
 * @ORM\Entity(repositoryClass="App\Repository\Activity\ActivityJoiningRequestRepository")
 * @UniqueEntity(
 *     fields={"activity", "recipitent"},
 *     errorPath="recipitent",
 *     message="ACTIVITY_JOINING_REQUEST_ALREADY_MADE_TOKEN"
 * )
 */
class ActivityJoiningRequest
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"get-request"})
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Groups({"get-request"})
     * @Assert\Type(type="bool")
     * @ORM\Column(type="boolean")
     */
    private $isAccepted;

    /**
     * @Groups({"get-request", "make-request"})
     * @Assert\NotNull(groups={"Default, makeRequestValidation"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity\Activity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @Groups({"get-request"})
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
