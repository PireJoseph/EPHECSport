<?php

namespace App\Form\Profile;

use App\Entity\User\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DisponibilityPatternType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => User::getDisponibilityPatternTokenArray()
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
