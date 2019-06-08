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
 *          "getCancellation" = {
 *              "method"="GET",
 *              "path"= "/activities/cancellations/{id}",
 *              "denormalization_context"={"groups"={"get-cancellation"} },
 *              "normalization_context"={"groups"={"get-cancellation"} }
 *           },
 *     },
 *     collectionOperations={
 *          "getCancellations" = {
 *              "method"="GET",
 *              "path"="/activities/cancellations/",
 *              "denormalization_context"={"groups"={"get-cancellations"} },
 *              "normalization_context"={"groups"={"get-cancellations"} },
 *          },
 *          "postCancellation" = {
 *              "method"="POST",
 *              "path"="/activities/cancellations/",
 *              "denormalization_context"={"groups"={"post-cancellation"} },
 *              "normalization_context"={"groups"={"post-cancellation"} },
 *              "validation_groups"={"postCancellationValidation"}
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\Activity\ActivityCancellationRepository")
 * @UniqueEntity(
 *     fields={"activity", "cancellingUser"},
 *     errorPath="cancellingUser",
 *     message="ACTIVITY_CANCELLATION_ALREADY_MADE_TOKEN"
 * )
 */
class ActivityCancellation
{
    /**
     * @Groups({"get-cancellation","get-cancellations","post-cancellation"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotNull(groups={"postCancellationValidation"})
     * @Groups({"get-cancellation","get-cancellations","post-cancellation"})
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Groups({"get-cancellation","get-cancellations","post-cancellation"})
     * @Assert\NotNull(groups={"Default,postCancellationValidation"})
     * @Assert\NotBlank(groups={"Default,postCancellationValidation"})
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=1024)
     */
    private $cancellationMotivation;

    /**
     * @Groups({"get-cancellation","get-cancellations","post-cancellation"})
     * @Assert\NotNull
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity\Activity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;

    /**
     * @Groups({"get-cancellation","get-cancellations","post-cancellation"})
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @Groups({"get-cancellation","get-cancellations","post-cancellation"})
     * @Assert\NotNull(groups={"Default"})
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cancellingUser;


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

    public function getCancellationMotivation(): ?string
    {
        return $this->cancellationMotivation;
    }

    public function setCancellationMotivation(string $cancellationMotivation): self
    {
        $this->cancellationMotivation = $cancellationMotivation;

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

    public function getCancellingUser(): ?User
    {
        return $this->cancellingUser;
    }

    public function setCancellingUser(?User $cancellingUser): self
    {
        $this->cancellingUser = $cancellingUser;

        return $this;
    }
}
