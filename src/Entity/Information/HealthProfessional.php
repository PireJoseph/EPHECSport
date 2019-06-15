<?php

namespace App\Entity\Information;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Location;
use App\Entity\picture;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     itemOperations={
 *          "getProfessional" = {
 *              "method"="GET",
 *              "path"= "/professionals/{id}",
 *              "denormalization_context"={"groups"={"get-professional"} },
 *              "normalization_context"={"groups"={"get-professional"} }
 *           },
 *     },
 *     collectionOperations={
 *          "getProfessionals" = {
 *              "method"="GET",
 *              "path"="/professionals/",
 *              "denormalization_context"={"groups"={"get-professionals"} },
 *              "normalization_context"={"groups"={"get-professionals"} },
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\Information\HealthProfessionalRepository")
 * @UniqueEntity(
 *     fields={"firstName", "lastName"},
 *     errorPath="firstName",
 *     message="HEALTH_PROFESSIONAL_ALREADY_EXISTING_TOKEN"
 * )
 * @UniqueEntity("email")
 * @UniqueEntity("phoneNumber")
 *
 */
class HealthProfessional
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get-professional","get-professionals"})
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-professional","get-professionals"})
     */
    private $firstName;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-professional","get-professionals"})
     */
    private $lastName;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-professional","get-professionals"})
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-professional","get-professionals"})
     */
    private $phoneNumber;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-professional","get-professionals"})
     */
    private $title;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Picture", cascade={"persist", "remove"})
     * @Groups({"get-professional","get-professionals"})
     */
    private $picture;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-professional","get-professionals"})
     */
    private $presentation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $webSiteAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addressAsText;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getWebSiteAddress(): ?string
    {
        return $this->webSiteAddress;
    }

    public function setWebSiteAddress(?string $webSiteAddress): self
    {
        $this->webSiteAddress = $webSiteAddress;

        return $this;
    }

    public function getAddressAsText(): ?string
    {
        return $this->addressAsText;
    }

    public function setAddressAsText(?string $addressAsText): self
    {
        $this->addressAsText = $addressAsText;

        return $this;
    }
}
