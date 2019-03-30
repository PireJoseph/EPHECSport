<?php

namespace App\Entity\User;

use App\Entity\Picture;
use App\Entity\Profile\DisponibilityPattern;
use App\Entity\Profile\ProfilePicture;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Entity\Profile\SchoolClass;
use App\Entity\Profile\SchoolSection;
use App\Entity\Profile\Success;
use App\Security\iHasRole;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Entity(repositoryClass="App\Repository\User\UserRepository")
 * @Vich\Uploadable
 * @UniqueEntity(fields={"username"}, message="Il existe déja un compte avec ce nom d'utilisatateur")
 */
class User implements UserInterface, iHasRole
{
    const USER_GENDER_KEY_MALE = 'M';
    const USER_GENDER_VALUE_MALE = 'homme';
    const USER_GENDER_KEY_FEMALE = 'F';
    const USER_GENDER_VALUE_FEMALE = 'femme';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Email()
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @var Date $birthDate
     *
     * @Assert\NotNull()
     * @Assert\Date()
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthDate;

    /**
     *
     * @Assert\NotNull()
     * @Assert\DateTime()
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $canGoAway;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $activityCostLimit;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isInjured;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPersonalProfileVisible;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $areActivityParticipationVisible;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $areSuccessUnlockedVisible;

    /**
     * @ORM\Column(nullable=true)
     * @ORM\ManyToMany(targetEntity="App\Entity\Profile\DisponibilityPattern")
     */
    private $disponibilityPattern;

    /**
     * @ORM\Column(nullable=true)
     * @ORM\ManyToMany(targetEntity="App\Entity\User\User")
     */
    private $preferedPartners;

    /**
     * @ORM\Column(nullable=true)
     * @ORM\ManyToOne(targetEntity="App\Entity\Profile\SchoolClass")
     */
    private $schoolClass;

    /**
     * @ORM\Column(nullable=true)
     * @ORM\ManyToOne(targetEntity="App\Entity\Profile\SchoolSection")
     */
    private $schoolSection;

    /**
     * @var Picture[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Picture", cascade={"persist"})
     * @ORM\JoinTable(name="user_pictures",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="picture_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $pictures;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Profile\ProfilePicture", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="user_profile_pictures",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="profile_picture_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $profilePicture;

    public function __construct()
    {
        $this->disponibilityPattern = new ArrayCollection();
        $this->preferedPartners = new ArrayCollection();
        $this->pictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = iHasRole::ROLE_USER;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    function __toString(){
        return $this->getUsername();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param mixed $birthDate
     * @return User
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCanGoAway(): ?bool
    {
        return $this->canGoAway;
    }

    public function setCanGoAway(?bool $canGoAway): self
    {
        $this->canGoAway = $canGoAway;

        return $this;
    }

    public function getActivityCostLimit(): ?int
    {
        return $this->activityCostLimit;
    }

    public function setActivityCostLimit(?int $activityCostLimit): self
    {
        $this->activityCostLimit = $activityCostLimit;

        return $this;
    }

    public function getIsInjured(): ?bool
    {
        return $this->isInjured;
    }

    public function setIsInjured(bool $isInjured): self
    {
        $this->isInjured = $isInjured;

        return $this;
    }

    public function getIsPersonalProfileVisible(): ?bool
    {
        return $this->isPersonalProfileVisible;
    }

    public function setIsPersonalProfileVisible(bool $isPersonalProfileVisible): self
    {
        $this->isPersonalProfileVisible = $isPersonalProfileVisible;

        return $this;
    }

    public function getAreActivityParticipationVisible(): ?bool
    {
        return $this->areActivityParticipationVisible;
    }

    public function setAreActivityParticipationVisible(bool $areActivityParticipationVisible): self
    {
        $this->areActivityParticipationVisible = $areActivityParticipationVisible;

        return $this;
    }

    /**
     * @return Collection|DisponibilityPattern[]
     */
    public function getDisponibilityPattern(): Collection
    {
        return $this->disponibilityPattern;
    }

    public function addDisponibilityPattern(DisponibilityPattern $disponibilityPattern): self
    {
        if (!$this->disponibilityPattern->contains($disponibilityPattern)) {
            $this->disponibilityPattern[] = $disponibilityPattern;
        }

        return $this;
    }

    public function removeDisponibilityPattern(DisponibilityPattern $disponibilityPattern): self
    {
        if ($this->disponibilityPattern->contains($disponibilityPattern)) {
            $this->disponibilityPattern->removeElement($disponibilityPattern);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAreSuccessUnlockedVisible()
    {
        return $this->areSuccessUnlockedVisible;
    }

    /**
     * @param mixed $areSuccessUnlockedVisible
     * @return User
     */
    public function setAreSuccessUnlockedVisible($areSuccessUnlockedVisible)
    {
        $this->areSuccessUnlockedVisible = $areSuccessUnlockedVisible;
        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getPreferedPartners(): Collection
    {
        return $this->preferedPartners;
    }

    public function addPreferedPartner(self $preferedPartner): self
    {
        if (!$this->preferedPartners->contains($preferedPartner)) {
            $this->preferedPartners[] = $preferedPartner;
        }

        return $this;
    }

    public function removePreferedPartner(self $preferedPartner): self
    {
        if ($this->preferedPartners->contains($preferedPartner)) {
            $this->preferedPartners->removeElement($preferedPartner);
        }

        return $this;
    }

    public function getSchoolClass(): ?SchoolClass
    {
        return $this->schoolClass;
    }

    public function setSchoolClass(?SchoolClass $schoolClass): self
    {
        $this->schoolClass = $schoolClass;

        return $this;
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

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function getProfilePicture(): ?ProfilePicture
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?ProfilePicture $profilePicture): self
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }


}
