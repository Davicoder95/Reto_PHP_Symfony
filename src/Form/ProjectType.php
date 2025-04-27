<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name')
        ->add('dateStart', null, [
            'widget' => 'single_text',
        ])
        ->add('dateFinish', null, [
            'widget' => 'single_text',
        ])
        ->add('employeAsigned', EntityType::class, [
            'class' => Employe::class,
            'choice_label' => 'name', 
            'multiple' => true, // Permite seleccionar varios empleados
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
