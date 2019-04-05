<?php

namespace App\Form\Activity;

use App\Entity\Activity\UserRelatedFeedback;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRelatedFeedBackLabelType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => UserRelatedFeedback::getLabelValueTokenArray()
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
