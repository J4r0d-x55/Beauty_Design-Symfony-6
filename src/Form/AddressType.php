<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => "Nom de votre adresse"
            ])
            ->add('firstname', TextType::class,[
                'label' => "Votre prénom"
            ])
            ->add('lastname', TextType::class,[
                'label' => "Votre nom"
            ])
            ->add('company', TextType::class,[
                'label' => "Nom de votre société (facultatif)",
                'required' => false
            ])
            ->add('address', TextType::class,[
                'label' => "Votre adresse"
            ])
            ->add('postal', NumberType::class,[
                'label' => "Votre code postale"
            ])
            ->add('city', TextType::class,[
                'label' => "Votre ville"
            ])
            ->add('country', CountryType::class,[
                'label' => "Votre pays"
            ])
            ->add('phone', TelType::class,[
                'label' => "Votre numéro de téléphone"
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    "class" => 'btn btn-light btn-md mt-3'
                ]
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
