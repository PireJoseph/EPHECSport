<?php

namespace App\Form\Profile;

use App\Entity\User\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez indiquer un nom d\'utilisateur',
                        'groups' => ['register_form']
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre nom d\'utilisateur doit contenir au minimum {{ limit }} caractères',
                        'max' => 128,
                        'maxMessage' => 'Votre nom d\'utilisateur ne doit pas excéder {{ limit }} caractères',
                        'groups' => ['register_form']
                    ]),
                ],
                'mapped' => false,

            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez indiquer un mot de passe',
                        'groups' => ['register_form']
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 128,
                        'maxMessage' => 'Votre mot de passe ne doit pas excéder {{ limit }} caractères',
                        'groups' => ['register_form']
                    ]),
                ],
                'mapped' => false,
            ])
            ->add('email', EmailType::class,[
                'label' => 'Adresse mail',
                'constraints'=> [
                    new Email([
                        'message' => "l'adresse email fournie n'est pas valide",
                        'groups' => ['register_form']
                    ])
                ],
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
