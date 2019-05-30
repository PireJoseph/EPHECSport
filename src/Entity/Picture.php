<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Activity\Activity;
use App\Entity\Promotion\EmeritusSportman;
use App\Entity\Promotion\OfficialTeam;
use App\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiProperty;


/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureRepository")
 * @Vich\Uploadable
 */
class Picture implements Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"activity-history","get-team","get-teams", "get-sportman", "get-sportmen", "get-link","get-links", "get-professional","get-professionals"})
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @var string
     * @Groups({"activity-history","get-team","get-teams","get-sportman", "get-sportmen", "get-link", "get-links", "get-professional","get-professionals"})
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="pictures", fileNameProperty="image")
     */
    private $imageFile;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", length=255)
     */
    private $updatedAt;


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

    /**
     * @param File|null $image
     * @return Picture
     * @throws \Exception
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return Picture
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * String representation of object
     * @link https://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->label,
            $this->image,
        ));
    }

    /**
     * Constructs the object
     * @link https://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,

            ) = unserialize($serialized);
    }
}
