<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 * @UniqueEntity(
 *     fields={"postCode", "city","streetOrPlace","number"},
 *     errorPath="number",
 *     message="LOCATION_ALREADY_EXISTING_TOKEN"
 * )
 * @UniqueEntity("label")
 *
 */
class Location
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
     * @Groups({"activity-history"})
     */
    private $label;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"activity-history"})
     */
    private $city;

    /**
     * @Assert\NotNull()
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $postCode;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     */
    private $streetOrPlace;

    /**
     * @Assert\NotNull()
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $number;

    public function __toString()
    {
        return $this->getString();
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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostCode(): ?int
    {
        return $this->postCode;
    }

    public function setPostCode(int $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getStreetOrPlace(): ?string
    {
        return $this->streetOrPlace;
    }

    public function setStreetOrPlace(string $streetOrPlace): self
    {
        $this->streetOrPlace = $streetOrPlace;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getString()
    {
        return $this->label . ', ' . $this->city;
    }

}
