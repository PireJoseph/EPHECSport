<?php

namespace App\Entity\Activity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     itemOperations={
 *         "get"= {
 *              "path"="/activities/feedbacks/{id}" ,
 *         },
 *         "getActivityHistoryFeedback" = {
 *              "method"="GET",
 *              "path"="/activities/{id}/feedbacks/" ,
 *              "denormalization_context"={"groups"={"activity-history-feedback"} },
 *              "normalization_context"={"groups"={"activity-history-feedback"} }
 *          },
 *          "put" ={
 *              "method"="PUT",
 *              "path"="/activities/feedbacks/{id}" ,
 *              "denormalization_context"={"groups"={"activity-history-feedback"} },
 *              "normalization_context"={"groups"={"activity-history-feedback"} }
 *           }
 *     },
 *     collectionOperations = {
 *        "post" = {
 *              "method"="POST",
 *              "path"="/activities/feedbacks/" ,
 *              "denormalization_context"={"groups"={"activity-history-feedback"} },
 *              "normalization_context"={"groups"={"activity-history-feedback"} },
 *              "validation_groups"={"post-activity-history-feedback"}
 *         }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\Activity\ActivityRelatedFeedbackRepository")
 * @UniqueEntity(
 *     fields={"activity", "author"},
 *     errorPath="author",
 *     message="ACTIVITY_RELATED_FEEDBACK_ALREADY_MADE_TOKEN"
 * )
 */
class ActivityRelatedFeedback
{

    const ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_NOTHING = 'ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_NOTHING';
    const ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_NOTHING = 'ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_NOTHING';
    
    const ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_BORING = 'ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_BORING';
    const ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_BORING = 'ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_BORING';

    const ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_EASY = 'ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_EASY';
    const ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_EASY = 'ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_EASY';

    const ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_FUN = 'ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_FUN';
    const ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_FUN = 'ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_FUN';

    const ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_EPIC = 'ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_EPIC';
    const ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_EPIC = 'ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_EPIC';

    const ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_CHALLENGING = 'ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_CHALLENGING';
    const ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_CHALLENGING = 'ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_CHALLENGING';


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"activity-history-feedback"})
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "La cotation minimale est de {{ limit }}",
     *      maxMessage = "La cotation maximale est de {{ limit }}",
     *      groups = {"Default","post-activity-history-feedback"}
     * )
     */
    private $activityRatingOutOfFive;

    /**
     * @Groups({"activity-history-feedback"})
     * @Assert\NotNull(groups = {"Default","post-activity-history-feedback"})
     * @Assert\NotBlank(groups = {"Default","post-activity-history-feedback"})
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @Groups({"activity-history-feedback"})
     * @Assert\NotNull(groups = {"Default","post-activity-history-feedback"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity\Activity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @Assert\NotNull(groups = {"Default"})
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @Groups({"activity-history-feedback"})
     * @Assert\NotNull(groups = {"Default"})
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActivityRatingOutOfFive(): ?int
    {
        return $this->activityRatingOutOfFive;
    }

    public function setActivityRatingOutOfFive(int $activityRatingOutOfFive): self
    {
        $this->activityRatingOutOfFive = $activityRatingOutOfFive;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getLabelTokenFromValue($value)
    {
        return  array_search($value, self::getLabelValueTokenArray(), true);
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public static function getLabelValueTokenArray(){
        return [
            self::ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_NOTHING => self::ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_NOTHING,
            self::ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_BORING => self::ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_BORING,
            self::ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_EASY => self::ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_EASY,
            self::ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_FUN => self::ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_FUN,
            self::ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_EPIC => self::ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_EPIC,
            self::ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_CHALLENGING => self::ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_CHALLENGING,
        ];
    }

}
