<?php

namespace App\Form;

use App\Entity\Employes;
use App\Entity\Mission;
use App\Repository\EmployesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', null, [
                'label' => 'Date de début de mission',
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'La date de début est requise.',
                    ]),
                ],
            ])
            ->add('dateFin', null, [
                'label' => 'Date de fin de mission',
                'widget' => 'single_text',
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
            ->add('employe', EntityType::class, [
                'label' => 'Ouvrier',
                'class' => Employes::class,
                'choice_label' => function(Employes $employes) {
                    return $employes->getNom() . ' ' . $employes->getPrenom();
                },
                'query_builder' => function(EmployesRepository $repoEmployes) {
                    return $repoEmployes->findEmployesByRoleOuvrier();
                },
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
