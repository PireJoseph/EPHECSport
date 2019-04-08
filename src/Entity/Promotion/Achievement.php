<?php

namespace App\Entity\Promotion;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\Promotion\AchievementRepository")
 * @UniqueEntity(
 *     fields={"label", "emeritusSportMan", "officialTeam", "acquiredAt"},
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
        return $this->acquiredAt;
    }

    public function setAcquiredAt(\DateTimeInterface $acquiredAt): self
    {
        $this->acquiredAt = $acquiredAt;

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
