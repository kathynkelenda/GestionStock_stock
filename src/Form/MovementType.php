<?php

namespace App\Form;

use App\Entity\Movement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateOfMovement')
            ->add('quantityMovement')
            ->add('type')
            ->add('To_know',EntityType::class,[
                'class'=> Movement::class,
                'choice_label'=>'quantityMovement'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movement::class,
        ]);
    }
}
