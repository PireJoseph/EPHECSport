<?php

namespace App\Entity\Profile;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\Profile\SuccessRepository")
 * @UniqueEntity(
 *     fields={"label", "user"},
 *     errorPath="user",
 *     message="SUCCESS_ALREADY_MADE_TOKEN"
 * )
 */
class Success
{

    const SUCCESS_LABEL_VALUE_TEN_ACTIVITY_PARTICIPATION = 'TEN_ACTIVITY_PARTICIPATION';
    const SUCCESS_LABEL_TOKEN_TEN_ACTIVITY_PARTICIPATION = 'SUCCESS_LABEL_VALUE_TOKEN_TEN_ACTIVITY_PARTICIPATION';
    const SUCCESS_LABEL_VALUE_TEN_TIMES_FRIENDLY = 'TEN_TIMES_FRIENDLY';
    const SUCCESS_LABEL_TOKEN_TEN_TIMES_FRIENDLY = 'SUCCESS_LABEL_TOKEN_TEN_TIMES_FRIENDLY';
    const SUCCESS_LABEL_VALUE_TEN_TIMES_MVP = 'TEN_TIMES_MVP';
    const SUCCESS_LABEL_TOKEN_TEN_TIMES_MVP = 'SUCCESS_LABEL_TOKEN_TEN_TIMES_MVP';
    const SUCCESS_LABEL_VALUE_TEN_TIMES_FAIR_PLAY = 'TEN_TIMES_FAIR_PLAY';
    const SUCCESS_LABEL_TOKEN_TEN_TIMES_FAIR_PLAY = 'SUCCESS_LABEL_TOKEN_TEN_TIMES_FAIR_PLAY';


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
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
