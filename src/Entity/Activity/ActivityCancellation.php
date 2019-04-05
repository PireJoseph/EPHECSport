<?php

namespace App\Entity\Activity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource()
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
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=2056)
     */
    private $cancellationMotivation;

    /**
     * @Assert\NotNull
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
     * @Assert\NotNull
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
