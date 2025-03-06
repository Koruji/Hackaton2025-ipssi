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
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'La date de début est requise.',
                    ]),
                ],
                'attr' => [
                    'min' => isset($options['dateDebut']) ? $options['dateDebut']->format('Y-m-d') : null,
                    'max' => isset($options['dateFin']) ? $options['dateFin']->format('Y-m-d') : null,
                ],
            ])
            ->add('dateFin', null, [
                'label' => 'Date de fin de mission',
                'widget' => 'single_text',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'La date de fin est requise.',
                    ]),
                    new Assert\GreaterThanOrEqual([
                        'propertyPath' => 'parent.all[dateDebut].data',
                        'message' => 'La date de fin doit être supérieure ou égale à la date de début.',
                    ]),
                ],
                'attr' => [
                    'min' => isset($options['dateDebut']) ? $options['dateDebut']->format('Y-m-d') : null,
                    'max' => isset($options['dateFin']) ? $options['dateFin']->format('Y-m-d') : null,
                ],
            ])
            ->add('employe', EntityType::class, [
                'label' => 'Ouvrier',
                'class' => Employes::class,
                'choice_label' => function(Employes $employes) {
                    return $employes->getNom() . ' ' . $employes->getPrenom();
                },
                'query_builder' => function(EmployesRepository $repoEmployes) use ($options) {
                    if (isset($options['dateDebut']) && isset($options['dateFin'])) {
                        return $repoEmployes->findAvailableEmployes($options['competencesChantier'], $options['dateDebut'], $options['dateFin']);
                    }
                    return $repoEmployes->findAll();
                },
                'attr' => [
                    'class' => 'form-control',
                    'data-dependent' => 'true',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
            'competencesChantier' => null,
            'dateDebut' => null,
            'dateFin' => null,
        ]);
    }
}
