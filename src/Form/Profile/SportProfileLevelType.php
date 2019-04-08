<?php

namespace App\Form\Profile;

use App\Entity\Profile\SportProfile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SportProfileLevelType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => SportProfile::getLevelTokenArray()
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
