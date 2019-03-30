<?php

namespace App\Entity\Profile;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Activity\Sport;
use App\Entity\Activity\SportClub;
use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\Profile\SportProfileRepository")
 */
class SportProfile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $level;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isAimingFun;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isAimingPerf;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $wantedTimesPerWeek;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $wantToBeNotifiedAboutThisSport;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVisible;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity\SportClub")
     */
    private $sportClub;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity\Sport")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sport;

    public function __toString()
    {
        return $this->user . ' - ' . $this->sport;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getIsAimingFun(): ?bool
    {
        return $this->isAimingFun;
    }

    public function setIsAimingFun(?bool $isAimingFun): self
    {
        $this->isAimingFun = $isAimingFun;

        return $this;
    }

    public function getIsAimingPerf(): ?bool
    {
        return $this->isAimingPerf;
    }

    public function setIsAimingPerf(?bool $isAimingPerf): self
    {
        $this->isAimingPerf = $isAimingPerf;

        return $this;
    }

    public function getWantedTimesPerWeek(): ?int
    {
        return $this->wantedTimesPerWeek;
    }

    public function setWantedTimesPerWeek(?int $wantedTimesPerWeek): self
    {
        $this->wantedTimesPerWeek = $wantedTimesPerWeek;

        return $this;
    }

    public function getWantToBeNotifiedAboutThisSport(): ?bool
    {
        return $this->wantToBeNotifiedAboutThisSport;
    }

    public function setWantToBeNotifiedAboutThisSport(?bool $wantToBeNotifiedAboutThisSport): self
    {
        $this->wantToBeNotifiedAboutThisSport = $wantToBeNotifiedAboutThisSport;

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

    public function getSportClub(): ?SportClub
    {
        return $this->sportClub;
    }

    public function setSportClub(?SportClub $sportClub): self
    {
        $this->sportClub = $sportClub;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
}
