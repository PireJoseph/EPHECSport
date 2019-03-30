<?php

namespace App\Entity\Promotion;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\Promotion\AchievementRepository")
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
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $AcquiredAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Promotion\EmeritusSportMan")
     */
    private $emeritusSportMan;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Promotion\OfficialTeam")
     */
    private $officialTeam;

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
        return $this->AcquiredAt;
    }

    public function setAcquiredAt(\DateTimeInterface $AcquiredAt): self
    {
        $this->AcquiredAt = $AcquiredAt;

        return $this;
    }

    public function getEmeritusSportMan(): ?EmeritusSportMan
    {
        return $this->emeritusSportMan;
    }

    public function setEmeritusSportMan(?EmeritusSportMan $EmeritusSportMan): self
    {
        $this->emeritusSportMan = $EmeritusSportMan;

        return $this;
    }

    public function getOfficialTeam(): ?OfficialTeam
    {
        return $this->officialTeam;
    }

    public function setOfficialTeam(?OfficialTeam $officialTeam): self
    {
        $this->officialTeam = $officialTeam;

        return $this;
    }
}
