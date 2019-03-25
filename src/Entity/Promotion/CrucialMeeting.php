<?php

namespace App\Entity\Promotion;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Activity\Sport;
use App\Entity\Location;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\Promotion\CrucialMeetingRepository")
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
     * @ORM\Column(type="datetime")
     */
    private $startAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comment;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Activity\Sport")
     */
    private $sport;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Promotion\EmeritusSportman")
     */
    private $emeritusSportman;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Promotion\OfficialTeam")
     */
    private $officialTeam;

    public function __construct()
    {
        $this->sport = new ArrayCollection();
        $this->emeritusSportman = new ArrayCollection();
        $this->officialTeam = new ArrayCollection();
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

    public function setEndAt(\DateTimeInterface $endAt): self
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

    /**
     * @return Collection|Sport[]
     */
    public function getSport(): Collection
    {
        return $this->sport;
    }

    public function addSport(Sport $sport): self
    {
        if (!$this->sport->contains($sport)) {
            $this->sport[] = $sport;
        }

        return $this;
    }

    public function removeSport(Sport $sport): self
    {
        if ($this->sport->contains($sport)) {
            $this->sport->removeElement($sport);
        }

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
     * @return Collection|EmeritusSportman[]
     */
    public function getEmeritusSportman(): Collection
    {
        return $this->emeritusSportman;
    }

    public function addEmeritusSportman(EmeritusSportman $emeritusSportman): self
    {
        if (!$this->emeritusSportman->contains($emeritusSportman)) {
            $this->emeritusSportman[] = $emeritusSportman;
        }

        return $this;
    }

    public function removeEmeritusSportman(EmeritusSportman $emeritusSportman): self
    {
        if ($this->emeritusSportman->contains($emeritusSportman)) {
            $this->emeritusSportman->removeElement($emeritusSportman);
        }

        return $this;
    }

    /**
     * @return Collection|OfficialTeam[]
     */
    public function getOfficialTeam(): Collection
    {
        return $this->officialTeam;
    }

    public function addOfficialTeam(OfficialTeam $officialTeam): self
    {
        if (!$this->officialTeam->contains($officialTeam)) {
            $this->officialTeam[] = $officialTeam;
        }

        return $this;
    }

    public function removeOfficialTeam(OfficialTeam $officialTeam): self
    {
        if ($this->officialTeam->contains($officialTeam)) {
            $this->officialTeam->removeElement($officialTeam);
        }

        return $this;
    }
}
