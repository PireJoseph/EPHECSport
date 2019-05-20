<?php

namespace App\Entity\User;

use App\Entity\Picture;
use App\Entity\Profile\ProfilePicture;
use DateTime;
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
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;


/**
 * @ORM\Entity(repositoryClass="App\Repository\User\UserRepository")
 * @Vich\Uploadable
 * @UniqueEntity(fields={"username"}, message="Il existe déja un compte avec ce nom d'utilisatateur")
 * @UniqueEntity(fields={"email"}, message="Il existe déja un compte avec cet emial")
 * @see http://schema.org/Person Documentation on Schema.org
 * @ApiResource(
 *     routePrefix="/user",
 *     itemOperations={
 *        "getUser" = {
 *              "method"="GET",
 *              "path"="/{id}" ,
 *              "denormalization_context"={"groups"={"get-user"} },
 *              "normalization_context"={"groups"={"get-user"} }
 *          },
 *     },
 *     collectionOperations={
 *         "getUsers" = {
 *              "method"="POST",
 *              "path"="/" ,
 *              "denormalization_context"={"groups"={"get-users"} },
 *              "normalization_context"={"groups"={"get-users"} }
 *          },
 *     },
 * )
 */
class User implements UserInterface, iHasRole
{
    const USER_GENDER_KEY_MALE = 'M';
    const USER_GENDER_VALUE_MALE = 'USER_GENDER_VALUE_TOKEN_MALE';
    const USER_GENDER_KEY_FEMALE = 'F';
    const USER_GENDER_VALUE_FEMALE = 'USER_GENDER_VALUE_TOKEN_FEMALE';

    const USER_DISPONIBILITY_PATTERN_VALUE_AFTERNOON = 'AFTERNOON';
    const USER_DISPONIBILITY_PATTERN_TOKEN_AFTERNOON = 'USER_DISPONIBILITY_PATTERN_TOKEN_AFTERNOON';
    const USER_DISPONIBILITY_PATTERN_VALUE_WEEKEND = 'WEEKEND';
    const USER_DISPONIBILITY_PATTERN_TOKEN_WEEKEND = 'USER_DISPONIBILITY_PATTERN_TOKEN_WEEKEND';
    const USER_DISPONIBILITY_PATTERN_VALUE_SUMMER_HOLYDAY = 'SUMMER_HOLYDAY';
    const USER_DISPONIBILITY_PATTERN_TOKEN_SUMMER_HOLYDAY = 'USER_DISPONIBILITY_PATTERN_TOKEN_SUMMER_HOLYDAY';


    /**
     * @ORM\Id()
     *
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ApiProperty(identifier=true)
     * @Groups({"get-user","get-users","get-invitation","get-invitations","get-cancellation","get-cancellations","post-cancellation", "get-user-feedback", "get-user-feedbacks","get-participations-for-an-activity"})
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     * @Groups({"get-user","get-users","get-invitation","get-invitations","get-cancellation","get-cancellations","post-cancellation", "get-user-feedback", "get-user-feedbacks","get-participations-for-an-activity"})
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
     * @Assert\Type(type="string")
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    private $plainTextPassword;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Email()
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @Assert\NotNull()
     * @Assert\Type(type="DateTime")
     * @var DateTime $birthDate
     * @ORM\Column(type="datetime")
     */
    private $birthDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gender;

    /**
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $description;

    /**
     * @Assert\Type(type="bool")
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $canGoAway;

    /**
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $activityCostLimit;

    /**
     * @Assert\Type(type="bool")
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isInjured;

    /**
     * @Assert\Type(type="bool")
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPersonalProfileVisible;

    /**
     * @Assert\Type(type="bool")
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $areActivityParticipationVisible;

    /**
     * @Assert\Type(type="bool")
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $areSuccessUnlockedVisible;

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


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User\User")
     */
    private $preferredPartners;

    /**
     * @ORM\Column(type="array")
     */
    private $disponibilityPatterns = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profile\SchoolClass")
     */
    private $schoolClass;





    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->preferredPartners = new ArrayCollection();
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
     * @return DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param DateTime $birthDate
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

    public function setGender(?string $gender): self
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

    /**
     * @return string|null
     */
    public function getPlainTextPassword() : ?string
    {
        return $this->plainTextPassword;
    }

    /**
     * @param string|null $plainTextPassword
     * @return User
     */
    public function setPlainTextPassword( string $plainTextPassword)
    {
        $this->plainTextPassword = $plainTextPassword;
        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getPreferredPartners(): Collection
    {
        return $this->preferredPartners;
    }

    public function addPreferredPartner(self $preferredPartner): self
    {
        if (!$this->preferredPartners->contains($preferredPartner)) {
            $this->preferredPartners[] = $preferredPartner;
        }

        return $this;
    }

    public function removePreferredPartner(self $preferredPartner): self
    {
        if ($this->preferredPartners->contains($preferredPartner)) {
            $this->preferredPartners->removeElement($preferredPartner);
        }

        return $this;
    }

    public function getDisponibilityPatterns(): ?array
    {
        return $this->disponibilityPatterns;
    }

    public function setDisponibilityPatterns(array $disponibilityPatterns): self
    {
        $this->disponibilityPatterns = $disponibilityPatterns;

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

    public static function getGenderTokenArray()
    {
        return [
            self::USER_GENDER_VALUE_MALE => self::USER_GENDER_KEY_MALE,
            self::USER_GENDER_VALUE_FEMALE => self::USER_GENDER_KEY_FEMALE,
        ];
    }

    public static function getDisponibilityPatternTokenArray()
    {
        return [
            self::USER_DISPONIBILITY_PATTERN_TOKEN_AFTERNOON => self::USER_DISPONIBILITY_PATTERN_VALUE_AFTERNOON,
            self::USER_DISPONIBILITY_PATTERN_TOKEN_WEEKEND => self::USER_DISPONIBILITY_PATTERN_VALUE_WEEKEND,
            self::USER_DISPONIBILITY_PATTERN_TOKEN_SUMMER_HOLYDAY => self::USER_DISPONIBILITY_PATTERN_VALUE_SUMMER_HOLYDAY,
        ];
    }

    public static function getRolesTokenArray()
    {
        return [
            iHasRole::USER_ROLE_TOKEN_USER => iHasRole::USER_ROLE_VALUE_USER,
            iHasRole::USER_ROLE_TOKEN_ADMIN => iHasRole::USER_ROLE_VALUE_ADMIN,
//            iHasRole::USER_ROLE_TOKEN_ALLOWED_TO_SWITCH => iHasRole::USER_ROLE_VALUE_ALLOWED_TO_SWITCH,
        ];
    }



}
