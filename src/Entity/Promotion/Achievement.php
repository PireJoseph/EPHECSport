<?php

namespace App\Entity\Promotion;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\Promotion\AchievementRepository")
 * @UniqueEntity(
 *     fields={"label","acquiredAt"},
 *     errorPath="label",
 *     message="ACHIEVEMENT_ALREADY_EXISTING_TOKEN"
 * )
 */
class Achievement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     */
    private $comment;

    /**
     * @Assert\NotNull()
     * @ORM\Column(type="datetime")
     */
    private $acquiredAt;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Promotion\EmeritusSportMan")
     */
    private $emeritusSportMen;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Promotion\OfficialTeam")
     */
    private $officialTeams;

    public function __construct()
    {
        $this->emeritusSportMen = new ArrayCollection();
        $this->officialTeams = new ArrayCollection();
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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getAcquiredAt(): ?\DateTimeInterface
    {
        return $this->acquiredAt;
    }

    public function setAcquiredAt(\DateTimeInterface $acquiredAt): self
    {
        $this->acquiredAt = $acquiredAt;

        return $this;
    }


    /**
     * @return Collection|EmeritusSportMan[]
     */
    public function getEmeritusSportMen(): Collection
    {
        return $this->emeritusSportMen;
    }

    public function addEmeritusSportMan(EmeritusSportMan $emeritusSportMan): self
    {
        if (!$this->emeritusSportMen->contains($emeritusSportMan)) {
            $this->emeritusSportMen[] = $emeritusSportMan;
        }

        return $this;
    }

    public function removeEmeritusSportMan(EmeritusSportMan $emeritusSportMan): self
    {
        if ($this->emeritusSportMen->contains($emeritusSportMan)) {
            $this->emeritusSportMen->removeElement($emeritusSportMan);
        }

        return $this;
    }

    /**
     * @return Collection|OfficialTeam[]
     */
    public function getOfficialTeams(): Collection
    {
        return $this->officialTeams;
    }

    public function addOfficialTeam(OfficialTeam $officialTeam): self
    {
        if (!$this->officialTeams->contains($officialTeam)) {
            $this->officialTeams[] = $officialTeam;
        }

        return $this;
    }

    public function removeOfficialTeam(OfficialTeam $officialTeam): self
    {
        if ($this->officialTeams->contains($officialTeam)) {
            $this->officialTeams->removeElement($officialTeam);
        }

        return $this;
    }
}
