<?php

namespace App\Entity\Information;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\picture;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\Information\ExternalLinkRepository")
 * @UniqueEntity("url")
 * @UniqueEntity("label")
 */
class ExternalLink
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
    private $url;

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
    private $description;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Picture", cascade={"persist", "remove"})
     */
    private $picture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?picture
    {
        return $this->picture;
    }

    public function setPicture(?picture $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
}