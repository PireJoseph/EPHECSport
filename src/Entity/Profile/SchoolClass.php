<?php

namespace App\Entity\Profile;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Profile\SchoolClassRepository")
 * @UniqueEntity("label")
 */
class SchoolClass
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
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="App\Entity\Profile\SchoolSection")
     * @ORM\JoinColumn(nullable=false)
     */
    private $schoolSection;

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

    public function __toString()
    {
        return $this->label;
    }

    public function getSchoolSection(): ?SchoolSection
    {
        return $this->schoolSection;
    }

    public function setSchoolSection(?SchoolSection $schoolSection): self
    {
        $this->schoolSection = $schoolSection;

        return $this;
    }
}
