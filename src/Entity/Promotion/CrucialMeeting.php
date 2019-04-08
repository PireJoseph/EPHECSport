<?php

namespace App\Entity\Promotion;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Activity\Sport;
use App\Entity\Location;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\Promotion\CrucialMeetingRepository")
 * @UniqueEntity(
 *     fields={"label", "startAt"},
 *     errorPath="label",
 *     message="CRUCIAL_MEETING_ALREADY_EXISTING_TOKEN"
 * )
 */
class CrucialMeeting
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotNull()
     * @ORM\Column(type="datetime")
     */
    private $startAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endAt;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="App\Entity\Location")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Activity\Sport")
     */
    private $sports;

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
        $this->sports = new ArrayCollection();
        $this->emeritusSportMen = new ArrayCollection();
        $this->officialTeams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|Sport[]
     */
    public function getSports(): Collection
    {
        return $this->sports;
    }

    public function addSport(Sport $sport): self
    {
        if (!$this->sports->contains($sport)) {
            $this->sports[] = $sport;
        }

        return $this;
    }

    public function removeSport(Sport $sport): self
    {
        if ($this->sports->contains($sport)) {
            $this->sports->removeElement($sport);
        }

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
