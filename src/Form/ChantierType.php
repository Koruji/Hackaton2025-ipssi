<?php

namespace App\Form;

use App\Entity\Chantier;
use App\Entity\Competence;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('competences', EntityType::class, [
                'class' => Competence::class,
                'choice_label' => 'nom',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'A venir' => 'A venir',
                    'En cours' => 'En cours',
                    'Terminé' => 'Terminé',
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chantier::class,
        ]);
    }
}
