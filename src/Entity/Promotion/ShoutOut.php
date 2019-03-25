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
     * @ORM\ManyToOne(targetEntity="App\Entity\Promotion\EmeritusSportman")
     */
    private $EmeritusSportmanTarget;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Promotion\OfficialTeam")
     */
    private $OfficialTeamTarget;

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

    public function getEmeritusSportmanTarget(): ?EmeritusSportman
    {
        return $this->EmeritusSportmanTarget;
    }

    public function setEmeritusSportmanTarget(?EmeritusSportman $EmeritusSportmanTarget): self
    {
        $this->EmeritusSportmanTarget = $EmeritusSportmanTarget;

        return $this;
    }

    public function getOfficialTeamTarget(): ?OfficialTeam
    {
        return $this->OfficialTeamTarget;
    }

    public function setOfficialTeamTarget(?OfficialTeam $OfficialTeamTarget): self
    {
        $this->OfficialTeamTarget = $OfficialTeamTarget;

        return $this;
    }
}
