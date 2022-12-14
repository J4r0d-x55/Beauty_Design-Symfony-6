<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom'  
            ])
            ->add('lastname', TextType::class, [
                'label' => "Nom"
            ])
            ->add('email', EmailType::class, [
                'label' => "Email"
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => new Length([
                    'min' => 8,
                    'max' => 30
                ]),
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identiques.',
                'label' => "Mot de passe",
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    
                ],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                ]
            ])
            
            ->add('submit', SubmitType::class, [
                "label" => "S'inscrire",
                'attr' => [
                    "class" => 'btn btn-light btn-md mt-3'
                ]
            ])
        ;    
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
