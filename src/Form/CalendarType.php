<?php

namespace App\Form;

use App\Entity\Calendar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                "label" => "Titre du rendez-vous"
            ])
            ->add('start', DateTimeType::class,[
                "label" => "Début",
                "date_widget" => "single_text"
            ])
            ->add('end', DateTimeType::class,[
                "label" => "Fin",
                "date_widget" => "single_text"
            ])
            ->add('description')
            ->add('background_color', ColorType::class,[
                "label" => "Couleur de fond"
            ])
            ->add('border_color', ColorType::class, [
                "label" => "Couleur des bordures"
            ])
            ->add('text_color', ColorType::class, [
                "label" => "Couleur du texte"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Calendar::class,
        ]);
    }
}
