<?php

namespace App\Form;

use App\Entity\Chantier;
use App\Entity\Employes;
use App\Entity\Mission;
use App\Repository\EmployesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('employe', EntityType::class, [
                'label' => 'Ouvrier',
                'class' => Employes::class,
                'choice_label' => function(Employes $employes) {
                    return $employes->getNom() . ' ' . $employes->getPrenom();
                },
                'query_builder' => function(EmployesRepository $repoEmployes) {
                    return $repoEmployes->findEmployesByRoleOuvrier();
                }
            ])
            ->add('dateDebut', null, [
                'label' => '',
                'widget' => 'single_text',
            ])
            ->add('dateFin', null, [
                'widget' => 'single_text',
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
