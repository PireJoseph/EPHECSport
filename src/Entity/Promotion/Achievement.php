<?php

namespace App\Entity\Promotion;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;

/**
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
     * @Groups({"get-team","get-teams","get-sportsman", "get-sportsmen"})
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-team","get-teams","get-sportsman", "get-sportsmen"})
     */
    private $label;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-team","get-teams","get-sportsman", "get-sportsmen"})
     */
    private $comment;

    /**
     * @Assert\NotNull()
     * @ORM\Column(type="datetime")
     * @Groups({"get-team","get-teams","get-sportsman", "get-sportsmen"})
     */
    private $acquiredAt;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Promotion\OfficialTeam", inversedBy="achievements")
     */
    private $teams;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Promotion\EmeritusSportMan", inversedBy="achievements")
     */
    private $sportMen;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->sportMen = new ArrayCollection();
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
     * @return Collection|OfficialTeam[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(OfficialTeam $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
        }

        return $this;
    }

    public function removeTeam(OfficialTeam $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
        }

        return $this;
    }

    /**
     * @return Collection|EmeritusSportMan[]
     */
    public function getSportMen(): Collection
    {
        return $this->sportMen;
    }

    public function addSportMan(EmeritusSportMan $sportMan): self
    {
        if (!$this->sportMen->contains($sportMan)) {
            $this->sportMen[] = $sportMan;
        }

        return $this;
    }

    public function removeSportMan(EmeritusSportMan $sportMan): self
    {
        if ($this->sportMen->contains($sportMan)) {
            $this->sportMen->removeElement($sportMan);
        }

        return $this;
    }
}
