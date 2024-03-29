<?php

namespace App\Entity\Activity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\Actions\Activity\GetUserRelatedFeedbackForAnActivityAndAUser;

/**
 * @ApiResource(
 *     itemOperations = {
 *          "getUserFeedback" = {
 *              "method"="GET",
 *              "path"= "/user/feedbacks/{id}",
 *              "denormalization_context"={"groups"={"get-user-feedback"} },
 *              "normalization_context"={"groups"={"get-user-feedback"} },
 *              "requirements"={"id"="\d+"}
 *           },
 *          "putUserFeedback" = {
 *              "method"="PUT",
 *              "path"="/user/feedbacks/{id}",
 *              "denormalization_context"={"groups"={"put-user-feedback"} },
 *              "normalization_context"={"groups"={"put-user-feedback"} },
 *              "requirements"={"id"="\d+"}
 *          }
 *     },
 *     collectionOperations = {
 *          "getUserFeedbacks" = {
 *              "method"="GET",
 *              "path"="/user/feedbacks/",
 *              "denormalization_context"={"groups"={"get-user-feedbacks"} },
 *              "normalization_context"={"groups"={"get-user-feedbacks"} }
 *          },
 *          "getUserFeedbackForAnActivity" = {
 *              "method"="GET",
 *              "path"= "/user/feedbacks/activities/{id}",
 *              "denormalization_context"={"groups"={"get-user-feedbacks"} },
 *              "normalization_context"={"groups"={"get-user-feedbacks"} },
 *              "controller"=GetUserRelatedFeedbackForAnActivityAndAUser::class,
 *              "requirements"={"id"="\d+"}
 *          },
 *          "postUserFeedback" = {
 *              "method"="POST",
 *              "path"="/user/feedbacks/",
 *              "denormalization_context"={"groups"={"post-user-feedback"} },
 *              "normalization_context"={"groups"={"post-user-feedback"} }
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\Activity\UserRelatedFeedbackRepository")
 * @UniqueEntity(
 *     fields={"activity", "user", "createdBy"},
 *     errorPath="user",
 *     message="USER_RELATED_FEEDBACK_ALREADY_MADE_TOKEN"
 * )
 */
class UserRelatedFeedback
{

    const USER_RELATED_FEEDBACK_LABEL_TOKEN_NOTHING = 'USER_RELATED_FEEDBACK_LABEL_TOKEN_NOTHING';
    const USER_RELATED_FEEDBACK_LABEL_VALUE_NOTHING = 'USER_RELATED_FEEDBACK_LABEL_VALUE_NOTHING';
    
    const USER_RELATED_FEEDBACK_LABEL_TOKEN_MVP = 'USER_RELATED_FEEDBACK_LABEL_TOKEN_MVP';
    const USER_RELATED_FEEDBACK_LABEL_VALUE_MVP = 'USER_RELATED_FEEDBACK_LABEL_VALUE_MVP';

    const USER_RELATED_FEEDBACK_LABEL_TOKEN_FAIRPLAY = 'USER_RELATED_FEEDBACK_LABEL_TOKEN_FAIRPLAY';
    const USER_RELATED_FEEDBACK_LABEL_VALUE_FAIRPLAY = 'USER_RELATED_FEEDBACK_LABEL_VALUE_FAIRPLAY';

    const USER_RELATED_FEEDBACK_LABEL_TOKEN_FRIENDLY = 'USER_RELATED_FEEDBACK_LABEL_TOKEN_FRIENDLY';
    const USER_RELATED_FEEDBACK_LABEL_VALUE_FRIENDLY = 'USER_RELATED_FEEDBACK_LABEL_VALUE_FRIENDLY';

    const USER_RELATED_FEEDBACK_LABEL_TOKEN_LATE = 'USER_RELATED_FEEDBACK_LABEL_TOKEN_LATE';
    const USER_RELATED_FEEDBACK_LABEL_VALUE_LATE = 'USER_RELATED_FEEDBACK_LABEL_VALUE_LATE';

    const USER_RELATED_FEEDBACK_LABEL_TOKEN_NEGATIVE_ATTITUDE = 'USER_RELATED_FEEDBACK_LABEL_TOKEN_NEGATIVE_ATTITUDE';
    const USER_RELATED_FEEDBACK_LABEL_VALUE_NEGATIVE_ATTITUDE = 'USER_RELATED_FEEDBACK_LABEL_VALUE_NEGATIVE_ATTITUDE';

    const USER_RELATED_FEEDBACK_LABEL_TOKEN_USER_MISSING = 'USER_RELATED_FEEDBACK_LABEL_TOKEN_USER_MISSING';
    const USER_RELATED_FEEDBACK_LABEL_VALUE_USER_MISSING = 'USER_RELATED_FEEDBACK_LABEL_VALUE_USER_MISSING';


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get-user-feedback", "get-user-feedbacks", "get-user-feedbacks", "post-user-feedback"})
     */
    private $id;

    /**
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-user-feedback", "put-user-feedback", "get-user-feedbacks", "post-user-feedback"})
     */
    private $label;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get-user-feedback", "put-user-feedback", "get-user-feedbacks", "post-user-feedback"})
     */
    private $createdBy;

    /**
     * @Assert\NotNull
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity\Activity")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get-user-feedback", "put-user-feedback", "get-user-feedbacks", "post-user-feedback"})
     */
    private $activity;

    /**
     * @Assert\NotNull
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get-user-feedback", "put-user-feedback", "get-user-feedbacks", "post-user-feedback"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsReallyPresent(): ?bool
    {
        return ($this->label !== self::USER_RELATED_FEEDBACK_LABEL_VALUE_USER_MISSING);
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

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(?Activity $activity): self
    {
        $this->activity = $activity;

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

    public static function getLabelValueTokenArray()
    {
        return [
            self::USER_RELATED_FEEDBACK_LABEL_TOKEN_NOTHING => self::USER_RELATED_FEEDBACK_LABEL_VALUE_NOTHING,
            self::USER_RELATED_FEEDBACK_LABEL_TOKEN_MVP => self::USER_RELATED_FEEDBACK_LABEL_VALUE_MVP,
            self::USER_RELATED_FEEDBACK_LABEL_TOKEN_FAIRPLAY => self::USER_RELATED_FEEDBACK_LABEL_VALUE_FAIRPLAY,
            self::USER_RELATED_FEEDBACK_LABEL_TOKEN_FRIENDLY => self::USER_RELATED_FEEDBACK_LABEL_VALUE_FRIENDLY,
            self::USER_RELATED_FEEDBACK_LABEL_TOKEN_LATE => self::USER_RELATED_FEEDBACK_LABEL_VALUE_LATE,
            self::USER_RELATED_FEEDBACK_LABEL_TOKEN_NEGATIVE_ATTITUDE => self::USER_RELATED_FEEDBACK_LABEL_VALUE_NEGATIVE_ATTITUDE,
            self::USER_RELATED_FEEDBACK_LABEL_TOKEN_USER_MISSING => self::USER_RELATED_FEEDBACK_LABEL_VALUE_USER_MISSING
        ];
    }

    public static function getLabelToken($labelValue)
    {
        $labelValueTokenArray = self::getLabelValueTokenArray();
        $labelToken = array_search($labelValue, $labelValueTokenArray);
        return $labelToken;
    }

}
