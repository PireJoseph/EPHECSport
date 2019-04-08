<?php

namespace App\Entity\Promotion;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\Promotion\ShoutOutRepository")
 * @UniqueEntity(
 *     fields={"content", "transmitter", "emeritusSportManTarget", "officialTeamTarget"},
 *     errorPath="content",
 *     message="SHOUTOUT_ALREADY_EXISTING_TOKEN"
 * )
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
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255, nullable=true)
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
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

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

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
