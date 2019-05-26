<?php

namespace App\Entity\Promotion;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\Actions\Promotion\GetShoutOutsForAnOfficialTeamAction;
use App\Controller\Actions\Promotion\GetShoutOutsForAnEmeritusSportManAction;

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
 *          "etShoutOutsForAnOfficialTeam" = {
 *              "method"="GET",
 *              "path"="/teams/{id}/shoutouts",
 *              "denormalization_context"={"groups"={"get-shoutouts"} },
 *              "normalization_context"={"groups"={"get-shoutouts"} },
 *              "controller"=GetShoutOutsForAnOfficialTeamAction::class,
 *          },
 *          "getShoutOutsForAnEmeritusSportMan" = {
 *              "method"="GET",
 *              "path"="/sportmen/{id}/shoutouts/",
 *              "denormalization_context"={"groups"={"get-shoutouts"} },
 *              "normalization_context"={"groups"={"get-shoutouts"} },
 *              "controller"=GetShoutOutsForAnEmeritusSportManAction::class,
 *          },
 *          "postShoutOuts" = {
 *              "method"="POST",
 *              "path"="/shoutouts/",
 *              "denormalization_context"={"groups"={"post-shoutout"} },
 *              "normalization_context"={"groups"={"post-shoutout"} },
 *              "validation_groups"={"postShoutOutValidation"}
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\Promotion\ShoutOutRepository")
 * @UniqueEntity(
 *     fields={"content", "author", "emeritusSportManTarget", "officialTeamTarget", "createdAt"},
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
     * @Groups({"get-shoutout","get-shoutouts", "post-shoutout"})
     */
    private $id;

    /**
     * @Assert\Length(
     *      max = 2048,
     *      min = 3,
     *      minMessage = "Your shout out cannot be shirter than {{ limit }} characters",
     *      maxMessage = "Your shout out cannot be longer than {{ limit }} characters",
     *      groups={"Default,postShoutOutValidation"}
     * )
     * @Assert\NotNull(groups={"Default,postShoutOutValidation"})
     * @Assert\NotBlank(groups={"Default,postShoutOutValidation"})
     * @Assert\Type(type="string", groups={"Default,postShoutOutValidation"})
     * @Groups({"get-shoutout","get-shoutouts", "post-shoutout"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"get-shoutout","get-shoutouts", "post-shoutout"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get-shoutout","get-shoutouts"})
     * @Groups({"get-shoutout","get-shoutouts", "post-shoutout"})
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Promotion\EmeritusSportMan")
     * @Groups({"get-shoutout","get-shoutouts", "post-shoutout"})
     */
    private $emeritusSportManTarget;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Promotion\OfficialTeam")
     * @Groups({"get-shoutout","get-shoutouts", "post-shoutout"})
     */
    private $officialTeamTarget;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get-shoutout","get-shoutouts", "post-shoutout"})
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
