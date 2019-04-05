<?php

namespace App\Form\Activity;

use App\Entity\Activity\ActivityRelatedFeedback;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityRelatedFeedbackLabelType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => ActivityRelatedFeedback::getLabelValueTokenArray()
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

}
