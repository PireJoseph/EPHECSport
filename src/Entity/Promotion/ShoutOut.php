<?php

namespace App\Entity\Promotion;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     itemOperations={
 *          "getShoutOut" = {
 *              "method"="GET",
 *              "path"= "/shoutouts/{id}",
 *              "denormalization_context"={"groups"={"get-shoutout"} },
 *              "normalization_context"={"groups"={"get-shoutout"} }
 *           },
 *     },
 *     collectionOperations={
 *          "getShoutOuts" = {
 *              "method"="GET",
 *              "path"="/shoutouts/",
 *              "denormalization_context"={"groups"={"get-shoutouts"} },
 *              "normalization_context"={"groups"={"get-shoutouts"} }
 *          },
 *          "postShoutOuts" = {
 *              "method"="POST",
 *              "path"="/shoutouts/",
 *              "denormalization_context"={"groups"={"post-shoutouts"} },
 *              "normalization_context"={"groups"={"post-shoutouts"} }
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\Promotion\ShoutOutRepository")
 * @UniqueEntity(
 *     fields={"content", "author", "emeritusSportManTarget", "officialTeamTarget"},
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
     * @Groups({"get-shoutout","get-shoutouts"})
     */
    private $id;

    /**
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get-shoutout","get-shoutouts", "post-shoutouts"})
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"get-shoutout","get-shoutouts"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get-shoutout","get-shoutouts"})
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Promotion\EmeritusSportMan")
     * @Groups({"get-shoutout","get-shoutouts", "post-shoutouts"})
     */
    private $emeritusSportManTarget;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Promotion\OfficialTeam")
     * @Groups({"get-shoutout","get-shoutouts", "post-shoutouts"})
     */
    private $officialTeamTarget;

    /**
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
