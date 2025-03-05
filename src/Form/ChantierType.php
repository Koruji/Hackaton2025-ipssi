<?php

namespace App\Form;

use App\Entity\Chantier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ChantierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('adresse')
            ->add('debutTravaux', null, [
                'widget' => 'single_text',
                'label' => 'Début des travaux',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'La date de début est requise.',
                    ]),
                ],
            ])
            ->add('finTravaux', null, [
                'widget' => 'single_text',
                'label' => 'Fin des travaux',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'La date de fin est requise.',
                    ]),
                    new Assert\GreaterThanOrEqual([
                        'value' => 'today',
                        'message' => 'La date de fin doit être supérieure à la date de début.',
                    ]),
                ],
            ])
            ->add('status')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chantier::class,
        ]);
    }
}
