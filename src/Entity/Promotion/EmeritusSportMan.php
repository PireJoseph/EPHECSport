<?php

namespace App\Entity\Promotion;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Activity\Sport;
use App\Entity\Activity\SportClub;
use App\Entity\Picture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     itemOperations={
 *          "getSportMen" = {
 *              "method"="GET",
 *              "path"= "/sportmen/{id}",
 *              "denormalization_context"={"groups"={"get-sportman"} },
 *              "normalization_context"={"groups"={"get-sportman"} }
 *           },
 *     },
 *     collectionOperations={
 *          "getSportMens" = {
 *              "method"="GET",
 *              "path"="/sportmen/",
 *              "denormalization_context"={"groups"={"get-sportmen"} },
 *              "normalization_context"={"groups"={"get-sportmen"} },
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\Promotion\EmeritusSportManRepository")
 * @UniqueEntity(
 *     fields={"firstName", "lastName"},
 *     errorPath="firstName",
 *     message="EMERITUS_SPORTMAN_ALREADY_EXISTING_TOKEN"
 * )
 */
class EmeritusSportMan
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get-meeting","get-meetings", "get-sportman", "get-sportmen"})
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-meeting","get-meetings", "get-sportman", "get-sportmen"})
     */
    private $firstName;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-meeting","get-meetings", "get-sportman", "get-sportmen"})
     */
    private $lastName;

    /**
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get-meeting","get-meetings", "get-sportman", "get-sportmen"})
     */
    private $nickName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-meeting","get-meetings", "get-sportman", "get-sportmen"})
     */
    private $gender;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-meeting","get-meetings", "get-sportman", "get-sportmen"})
     */
    private $role;

    /**
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity\Sport")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get-meeting","get-meetings", "get-sportman", "get-sportmen"})
     */
    private $sport;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity\SportClub")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"get-meeting","get-meetings", "get-sportman", "get-sportmen"})
     */
    private $sportClub;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Picture", cascade={"persist"})
     * @ORM\JoinTable(name="emeritus_sport_man_pictures",
     *      joinColumns={@ORM\JoinColumn(name="emeritus_sport_man_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="picture_id", referencedColumnName="id", unique=true)}
     * )
     * @Groups({"get-meeting","get-meetings", "get-sportman", "get-sportmen"})
     */
    private $pictures;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Promotion\Achievement", mappedBy="sportMen")
     * @Groups({"get-meeting","get-meetings", "get-sportman", "get-sportmen"})
     */
    private $achievements;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->achievements = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName . ' - ' . $this->sport;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getNickName(): ?string
    {
        return $this->nickName;
    }

    public function setNickName(?string $nickName): self
    {
        $this->nickName = $nickName;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

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

    public function getSportClub(): ?SportClub
    {
        return $this->sportClub;
    }

    public function setSportClub(?SportClub $sportClub): self
    {
        $this->sportClub = $sportClub;

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

    /**
     * @return Collection|Achievement[]
     */
    public function getAchievements(): Collection
    {
        return $this->achievements;
    }

    public function addAchievement(Achievement $achievement): self
    {
        if (!$this->achievements->contains($achievement)) {
            $this->achievements[] = $achievement;
            $achievement->addSportMan($this);
        }

        return $this;
    }

    public function removeAchievement(Achievement $achievement): self
    {
        if ($this->achievements->contains($achievement)) {
            $this->achievements->removeElement($achievement);
            $achievement->removeSportMan($this);
        }

        return $this;
    }

}
