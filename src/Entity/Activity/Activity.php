<?php

namespace App\Entity\Activity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Location;
use App\Entity\Picture;
use App\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ApiResource(
 *     collectionOperations={
 *         "get",
 *         "getActivityHistory" = {
 *              "method"="GET",
 *              "path"="/activities/history/" ,
 *              "denormalization_context"={"groups"={"activity-history"} },
 *              "normalization_context"={"groups"={"activity-history"} }
 *          },
 *     },
 *     )
 * @ORM\Entity(repositoryClass="App\Repository\Activity\ActivityRepository")
 * @UniqueEntity("label")
 */
class Activity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @Groups({"activity-history"})
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @Groups({"activity-history"})
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cost;

    /**
     * @Assert\DateTime
     * @var string A "Y-m-d H:i:s" formatted value
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startAt;

    /**
     * @Groups({"activity-history"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endAt;

    /**
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maxNumberOfPlayer;

    /**
     * @Assert\Type(type="bool")
     * @ORM\Column(type="boolean")
     */
    private $isJoinableByAnyone;

    /**
     * @Assert\Type(type="bool")
     * @ORM\Column(type="boolean")
     */
    private $isVisible;

    /**
     * @Assert\Type(type="bool")
     * @ORM\Column(type="boolean")
     */
    private $isPublished;

    /**
     * @Groups({"activity-history"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Location")
     */
    private $location;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Activity\Material")
     */
    private $material;

    /**
     * @Groups({"activity-history"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity\Sport")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sport;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @Groups({"activity-history"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Picture" , cascade={"persist"})
     * @ORM\JoinTable(name="activity_pictures",
     *      joinColumns={@ORM\JoinColumn(name="activity_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="picture_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $pictures;

    public function __construct()
    {
        $this->material = new ArrayCollection();
        $this->pictures = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->label . ' - ' . $this->startAt->format('d/m/Y');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(?int $cost): self
    {
        $this->cost = $cost;

        return $this;
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

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getMaxNumberOfPlayer(): ?int
    {
        return $this->maxNumberOfPlayer;
    }

    public function setMaxNumberOfPlayer(?int $maxNumberOfPlayer): self
    {
        $this->maxNumberOfPlayer = $maxNumberOfPlayer;

        return $this;
    }

    public function getIsJoinableByAnyone(): ?bool
    {
        return $this->isJoinableByAnyone;
    }

    public function setIsJoinableByAnyone(bool $isJoinableByAnyone): self
    {
        $this->isJoinableByAnyone = $isJoinableByAnyone;

        return $this;
    }

    public function getIsVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection|Material[]
     */
    public function getMaterial(): Collection
    {
        return $this->material;
    }

    public function addMaterial(Material $material): self
    {
        if (!$this->material->contains($material)) {
            $this->material[] = $material;
        }

        return $this;
    }

    public function removeMaterial(Material $material): self
    {
        if ($this->material->contains($material)) {
            $this->material->removeElement($material);
        }

        return $this;
    }

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): self
    {
        $this->sport = $sport;

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

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->contains($picture)) {
            $this->pictures->removeElement($picture);
        }

        return $this;
    }

}
