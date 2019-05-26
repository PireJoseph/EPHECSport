<?php

namespace App\Entity\Promotion;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Activity\Sport;
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
 *          "getTeam" = {
 *              "method"="GET",
 *              "path"= "/teams/{id}",
 *              "denormalization_context"={"groups"={"get-team"} },
 *              "normalization_context"={"groups"={"get-team"} },
 *              "requirements"={"id"="\d+"}
 *           },
 *     },
 *     collectionOperations={
 *          "getTeams" = {
 *              "method"="GET",
 *              "path"="/teams/",
 *              "denormalization_context"={"groups"={"get-teams"} },
 *              "normalization_context"={"groups"={"get-teams"} },
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\Promotion\OfficialTeamRepository")
 * @UniqueEntity("name")
 */
class OfficialTeam
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get-team","get-teams","get-meeting","get-meetings"})
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-team","get-teams","get-meeting","get-meetings"})
     */
    private $name;

    /**
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get-team","get-teams","get-meeting","get-meetings"})
     */
    private $shortName;

    /**
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get-team","get-teams","get-meeting","get-meetings"})
     */
    private $nickName;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-team","get-teams","get-meeting","get-meetings"})
     */
    private $label;

    /**
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity\Sport")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get-team","get-teams","get-meeting","get-meetings"})
     */
    private $sport;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Picture", cascade={"persist"})
     * @ORM\JoinTable(name="official_team_pictures",
     *      joinColumns={@ORM\JoinColumn(name="official_team_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="picture_id", referencedColumnName="id", unique=true)}
     * )
     * @Groups({"get-team","get-teams"})
     */
    private $pictures;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Promotion\Achievement", mappedBy="teams")
     * @Groups({"get-team","get-teams","get-meeting","get-meetings"})
     */
    private $achievements;


    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->achievements = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->shortName . ' : ' . $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(string $shortName): self
    {
        $this->shortName = $shortName;

        return $this;
    }

    public function getNickName(): ?string
    {
        return $this->nickName;
    }

    public function setNickName(string $nickName): self
    {
        $this->nickName = $nickName;

        return $this;
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

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): self
    {
        $this->sport = $sport;

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
            $achievement->addTeam($this);
        }

        return $this;
    }

    public function removeAchievement(Achievement $achievement): self
    {
        if ($this->achievements->contains($achievement)) {
            $this->achievements->removeElement($achievement);
            $achievement->removeTeam($this);
        }

        return $this;
    }
}
