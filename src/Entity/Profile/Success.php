<?php

namespace App\Entity\Profile;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
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
    const SUCCESS_LABEL_TOKEN_TEN_ACTIVITY_PARTICIPATION = 'SUCCESS_LABEL_TOKEN_TEN_ACTIVITY_PARTICIPATION';
    const SUCCESS_THEME_COLOR_TEN_ACTIVITY_PARTICIPATION = 'w3-theme-d5';
    const SUCCESS_LABEL_VALUE_TEN_TIMES_FRIENDLY = 'TEN_TIMES_FRIENDLY';
    const SUCCESS_LABEL_TOKEN_TEN_TIMES_FRIENDLY = 'SUCCESS_LABEL_TOKEN_TEN_TIMES_FRIENDLY';
    const SUCCESS_THEME_COLOR_TEN_TIMES_FRIENDLY = 'w3-theme-d2';
    const SUCCESS_LABEL_VALUE_TEN_TIMES_MVP = 'TEN_TIMES_MVP';
    const SUCCESS_LABEL_TOKEN_TEN_TIMES_MVP = 'SUCCESS_LABEL_TOKEN_TEN_TIMES_MVP';
    const SUCCESS_THEME_COLOR_TEN_TIMES_MVP = 'w3-theme';
    const SUCCESS_LABEL_VALUE_TEN_TIMES_FAIR_PLAY = 'TEN_TIMES_FAIR_PLAY';
    const SUCCESS_LABEL_TOKEN_TEN_TIMES_FAIR_PLAY = 'SUCCESS_LABEL_TOKEN_TEN_TIMES_FAIR_PLAY';
    const SUCCESS_THEME_COLOR_TEN_TIMES_FAIR_PLAY = 'w3-theme-l1';


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

    public function getLabelTokenFromValue($value)
    {
        return self::getLabelTokenFromValue($value);
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

    public static function getSuccessColorThemeArray()
    {
        $colorThemeArray = [
            self::SUCCESS_LABEL_VALUE_TEN_ACTIVITY_PARTICIPATION => self::SUCCESS_THEME_COLOR_TEN_ACTIVITY_PARTICIPATION,
            self::SUCCESS_LABEL_VALUE_TEN_TIMES_FRIENDLY => self::SUCCESS_THEME_COLOR_TEN_TIMES_FRIENDLY,
            self::SUCCESS_LABEL_VALUE_TEN_TIMES_MVP => self::SUCCESS_THEME_COLOR_TEN_TIMES_MVP,
            self::SUCCESS_LABEL_VALUE_TEN_TIMES_FAIR_PLAY => self::SUCCESS_THEME_COLOR_TEN_TIMES_FAIR_PLAY
        ];
        return $colorThemeArray;
    }

    public static function getSuccessTokenArray()
    {
        $tokenArray = [
            self::SUCCESS_LABEL_VALUE_TEN_ACTIVITY_PARTICIPATION => self::SUCCESS_LABEL_TOKEN_TEN_ACTIVITY_PARTICIPATION,
            self::SUCCESS_LABEL_VALUE_TEN_TIMES_FRIENDLY => self::SUCCESS_LABEL_TOKEN_TEN_TIMES_FRIENDLY,
            self::SUCCESS_LABEL_VALUE_TEN_TIMES_MVP => self::SUCCESS_LABEL_TOKEN_TEN_TIMES_MVP,
            self::SUCCESS_LABEL_VALUE_TEN_TIMES_FAIR_PLAY => self::SUCCESS_LABEL_TOKEN_TEN_TIMES_FAIR_PLAY
        ];
        return $tokenArray;
    }

    public static function getSuccessColorTheme($value)
    {
        $colorThemeArray = self::getSuccessColorThemeArray();
        if (array_key_exists($value, $colorThemeArray)){
            return $colorThemeArray[$value];
        }
        return null;
    }

    public static function getSuccessToken($value)
    {
        $tokenArray = self::getSuccessTokenArray();
        if (array_key_exists($value, $tokenArray)){
            return $tokenArray[$value];
        }
        return null;
    }
}
