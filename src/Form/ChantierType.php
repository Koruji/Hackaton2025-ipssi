<?php

namespace App\Form;

use App\Entity\Chantier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ChantierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('adresse', TextareaType::class)
            ->add('debutTravaux', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('finTravaux', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'En cours' => 'En cours',
                    'Fini' => 'Fini',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chantier::class,
        ]);
    }
}
