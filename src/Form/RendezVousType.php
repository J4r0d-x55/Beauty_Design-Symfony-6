<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\RendezVous;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class,[
                'label' => "Votre prénom"
            ])
            ->add('lastName', TextType::class,[
                "label" => "Votre nom"
            ])
            ->add('email', Emailtype::class,[
                "label" => "Votre email"
            ])
            ->add('prestation', ChoiceType::class,[
                "label" => "Veuillez selectionner une prestations :",
                "choices" => [
                "Pose d'ongles résine mains" => "Pose d'ongles résine mains",
                "Pose d'ongles résine pieds" => "Pose d'ongles résine pieds",
                "Gommage et modelage visage" => "Gommage et modelage visage",
                "Pose complète cil à cil" => "Pose complète cil à cil",
                "Pose cil volume russe" => "Pose cil volume russe"
                ],
            ])
            ->add('date', DateType::class,[
                "label" => "Veuillez choisir la dâte du rendez-vous :",
                'format' => 'yyyy-MM-dd'
            ])
            ->add('time', TimeType::class,[
                "label" => "Veuillez choisir l'heure du rendez-vous :",
                'widget' => 'single_text'
            ])
            ->add('demande', TextType::class,[
                "label" => "Avez-vous une demande particulière ?",
                "required" => false
            ])
            ->add('submit', SubmitType::class, [
                "label" => "Envoyer",
                'attr' => [
                    "class" => 'btn btn-light btn-md mt-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
