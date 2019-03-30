<?php

namespace App\Entity\Promotion;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\Promotion\ShoutOutRepository")
 */
class ShoutOut
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
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Promotion\EmeritusSportMan")
     */
    private $emeritusSportManTarget;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Promotion\OfficialTeam")
     */
    private $officialTeamTarget;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $transmitter;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getEmeritusSportManTarget(): ?EmeritusSportMan
    {
        return $this->emeritusSportManTarget;
    }

    public function setEmeritusSportManTarget(?EmeritusSportMan $emeritusSportManTarget): self
    {
        $this->emeritusSportManTarget = $emeritusSportManTarget;

        return $this;
    }

    public function getOfficialTeamTarget(): ?OfficialTeam
    {
        return $this->officialTeamTarget;
    }

    public function setOfficialTeamTarget(?OfficialTeam $officialTeamTarget): self
    {
        $this->officialTeamTarget = $officialTeamTarget;

        return $this;
    }

    public function getTransmitter(): ?User
    {
        return $this->transmitter;
    }

    public function setTransmitter(?User $transmitter): self
    {
        $this->transmitter = $transmitter;

        return $this;
    }
}
