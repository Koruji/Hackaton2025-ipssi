<?php

namespace App\Form;

use App\Entity\Chantier;
use App\Entity\Employes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChantierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('adresse')
            ->add('debutTravaux', null, [
                'widget' => 'single_text',
            ])
            ->add('finTravaux', null, [
                'widget' => 'single_text',
            ])
            ->add('status')
            ->add('employes', EntityType::class, [
                'class' => Employes::class,
                'choice_label' => 'id',
                'multiple' => true,
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
